<template>
    <router-link
        :exact="link.exact"
        :to="to"
        tag="li"
        :class="[link.class, 'nav-item', (hasDropdown) ? 'dropdown' : null, open ? 'show' : '']"
        @mouseover.native="mouseOver"
        @mouseleave.native="mouseLeave"
        @click.native="click"
    >
        <a
            :id="id"
            :class="['nav-link']"
            :data-toggle="(hasDropdown) ? 'dropdown' : null"
            :aria-haspopup="(hasDropdown) ? 'true' : null"
            :aria-expanded="(hasDropdown) ? (open) ? 'true' : 'false' : null"
        >
            <template v-if="hasIcon">
                <span class="icon"><i :class="'icon icon-' + link.icon"></i></span>
                <span class="text">{{link.text}}</span>
            </template>

            <template v-else="hasIcon">
                {{link.text}}
            </template>

            <span v-if="link.notifications" class="badge" v-text="link.notifications"></span>
        </a>

        <transition
            v-on:before-enter="collapseMenuBeforeEnter"
            v-on:enter="collapseMenuEnter"
            v-on:leave="collapseMenuLeave"
            v-bind:css="false"
        >
            <div v-if="hasDropdown && open" class="side-dropdown-menu" :aria-labelledby="id">
                <div class="overflow">
                    <span class="side-dropdown-title">{{link.text}}</span>
                    <dropdown-item @dropdown-item-clicked="subItemClickedMethod" v-for="(link, index) in linksDisplayed" :link="link" :key="index"></dropdown-item>
                </div>
            </div>
        </transition>
    </router-link>
</template>

<script>
    import DropdownItem from './DropdownItem.vue';
    let dropdownMixins = require('../mixins').dropdownMixins;

    export default {
        data: function () {
            return {
                open: false,
                clicked: false,
                subItemClicked: false,
            };
        },

        methods: {
            mouseOver(e) {
                if (this.hasDropdown && (!this.clicked || this.subItemClicked) && !this.open) {
                    e.preventDefault();
                    this.toggleDropdown('open', true);
                    this.clicked = false;
                    this.subItemClicked = false;
                    return false;
                }

                return true;
            },

            mouseLeave(e) {
                this.clicked = false;

                if (this.hasDropdown) {
                    e.preventDefault();
                    this.toggleDropdown('open', false);
                    return false;
                }

                return true;
            },

            click(e) {
                console.log("clicked");
                // Si tiene dropdown y no esta abierto lo expando
                if (this.hasDropdown && !this.open) {
                    e.preventDefault();
                    this.toggleDropdown('open', true);
                    this.clicked = true;
                    return false;
                } else if (this.hasDropdown) {
                    this.clicked = true;
                }

                // var event = new Event('mouseleave');
                // this.$el.dispatchEvent(event);

                // Si tiene dropwdown y ya estaba o no tiene dropdown
                // abro el link normalmente
                bus.$emit('toggle-sidenavbar', false);
                this.toggleDropdown('open', false);
                return true;
            },

            subItemClickedMethod() {
                console.log("subclicked");
                this.subItemClicked = true;
            },

            collapseMenuBeforeEnter: function (el) {
                if (bus.isDesktop()) {
                    this.collapseHorizontalBeforeEnter(el);
                } else {
                    this.collapseVerticalBeforeEnter(el);
                }
            },

            collapseMenuEnter: function (el, done) {
                if (bus.isDesktop()) {
                    this.collapseHorizontalEnter(el, done);
                } else {
                    this.collapseVerticalEnter(el, done);
                }
            },

            collapseMenuLeave: function (el, done) {
                if (bus.isDesktop()) {
                    this.collapseHorizontalLeave(el, done);
                } else {
                    this.collapseVerticalLeave(el, done);
                }
            },
        },

        computed: {
            id: function () {
                if (this.link.id) {
                    return this.link.id;
                }

                // Si tiene dropdownMixinsn necesita un id para el atributo aria-labelledby
                if (this.hasDropdown) {
                    return this.elementName + '-' + (parseInt(this.index)+1).toString();
                }

                return null;
            },

            to() {
                if (this.link.route) {
                    return { name: this.link.route, params: this.link.route_params }
                }

                return this.link.href;
            },

            linksDisplayed() {
                return (this.link.items) ? this.link.items.filter(item => item.hide !== true) : [];
            },

            hasDropdown: function () {
                return this.linksDisplayed.length > 0
            },

            hasIcon: function () {
                return this.link.icon;
            },
        },

        props: {
            'link': null,
            'index': null,
            'element-name': {
                default: 'nav-link'
            },
        },

        components: {
            DropdownItem
        },

        mixins: [dropdownMixins],
    }
</script>
