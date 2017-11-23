<template>
  <div class="FormLocation">
    <b-form-group label="Ubicación" class="mr-3">
      <b-form-input v-model="address" @keyup.native="newAddress" />
      <div v-if="firstAddresses.length || calculating" class="FormLocation__addresses" >
        <a href="" @click.prevent="selectAddress(address)" class="FormLocation__address" v-for="address in firstAddresses">
          {{address.formatted_address}}
        </a>
        <span v-if="calculating" class="FormLocation__searching">
          <i class="spinner icon-spinner"></i> Buscando...
        </span>
      </div>
    </b-form-group>

    <div ref="container" class="FormLocation__container"></div>
  </div>
</template>

<script>
export default {
  props: {
    apiKey: {
      type: String,
      required: true
    },
    initialLatitude: {
      type: Number,
      default: 55.01657628017477
    },
    initialLongitude: {
      type: Number,
      default: -7.309233337402361
    },
    value: {
      type: String
    },
    isAddressPredefined: {
      type: Boolean,
      default: false
    }
  },

  data () {
    return {
      address: '',
      isManualChanged: this.isAddressPredefined,
      map: null,
      marker: null,
      searchTimeOut: null,
      calculating: false,
      addresses: [],
      coordinates: {
        lat: this.latitude,
        lng: this.longitude
      }
    }
  },

  computed: {
    encodedAddress () {
      return encodeURI(this.address)
    },

    firstAddresses () {
      if (!this.addresses) {
        return []
      }

      return this.addresses.slice(0, 5)
    }
  },

  watch: {
    coordinates: {
      handler (coordinates) {
        this.marker.setPosition(coordinates)
        this.map.panTo(coordinates)
      },
      deep: true
    },
    address (address) {
      this.$emit('input', address)
    }
  },

  created () {
    this.address = this.value
    this.coordinates.lat = this.initialLatitude
    this.coordinates.lng = this.initialLongitude
  },

  mounted () {
    // Set coordinates
    let myLatlng = new google.maps.LatLng(this.coordinates.lat, this.coordinates.lng)

    // Options
    let mapOptions = {
      zoom: 14,
      center: myLatlng
    }

    // Apply options
    this.map = new google.maps.Map(this.$refs.container, mapOptions)

    // Add marker
    this.marker = new google.maps.Marker({
      position: myLatlng,
      map: this.map
    })

    this.marker.setMap(this.map)

    google.maps.event.addListener(this.map, 'center_changed', () => {
      let lat = this.map.getCenter().lat()
      let lon = this.map.getCenter().lng()
      let newLatLng = {lat: lat, lng: lon}
      this.coordinates = newLatLng
      this.$emit('location-updated', newLatLng, this.isManualChanged)
    })

    google.maps.event.addListener(this.map, 'dragstart', () => {
      this.isManualChanged = true
    })

    if (!this.coordinates.lat || !this.coordinates.lng) {
      this.searchByAddress()
    }
  },

  methods: {
    newAddress () {
      if (!this.address) {
        return
      }

      if (this.searchTimeOut) {
        clearTimeout(this.searchTimeOut)
      }
      this.calculating = true
      this.searchTimeOut = setTimeout(() => {
        clearTimeout(this.searchTimeOut)
        this.searchByAddress()
      }, 500)
    },

    selectAddress (address) {
      this.coordinates.lat = address.geometry.location.lat
      this.coordinates.lng = address.geometry.location.lng
      this.addresses = []
      this.address = address.formatted_address
    },

    searchByAddress () {
      if (!this.address) {
        return
      }

      this.isManualChanged = false

      axios.get(
        `https://maps.googleapis.com/maps/api/geocode/json?address=${this.encodedAddress}&key=${this.apiKey}&region=mx`,
        {
          requestId: 'google-maps',
          transformRequest: [function (data, headers) {
            delete headers['X-Socket-Id']
            delete headers['common']
            return data
          }]
        }
      ).then((response) => {
        this.calculating = false
        let results = response.data.results
        this.addresses = results
        if (results.length) {
          this.coordinates.lat = results[0].geometry.location.lat
          this.coordinates.lng = results[0].geometry.location.lng
        }
      }).catch(thrown => {
        this.calculating = false
        if (axios.isCancel(thrown)) {
          // console.log('Request canceled', thrown.message);
        } else {
          console.log(thrown.message)
        }
      })
    }
  }
}
</script>

<style lang="scss">
@import "resources/assets/sass/globals";

.FormLocation {
  display: flex;
}

.FormLocation__addresses {
  border: $input-btn-border-width solid $input-border-color;
  display: flex;
  flex-direction: column;
}

.FormLocation__address {
  display: block;
  padding: $input-btn-padding-y $input-btn-padding-x;
  font-size: 0.75rem;
  line-height: $input-btn-line-height;
  color: $input-color;
  background-color: $input-bg;
  border-bottom: $input-btn-border-width solid $input-border-color;
  &:hover {
    background-color: $primary;
    color: #FFF;
  }
}

.FormLocation__searching {
  display: block;
  padding: $input-btn-padding-y $input-btn-padding-x;
  font-size: 0.85rem;
  line-height: $input-btn-line-height;
  background-color: $input-bg;
}

.FormLocation__container {
    height: 200px;
    width: 50%;
}
</style>
