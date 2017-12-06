<template>
  <div class="project-img">
    <video-player
      v-if="video"
      ref="videoPlayer"
      :options="playerOptions"
      :playsinline="true"
      width="100%"
      height="500"
    />
    <a v-else class="no-video" :href="link">
      <div class="video-js vjs-fluid vjs_video_3-dimensions vjs-youtube">
        <div class="vjs-poster" :style="'background-image:url(' + image + ')'">

        </div><!-- /.vjs-poster -->
      </div><!-- /.video-js vjs-fluid -->

    </a><!-- /.video-player -->

    <!-- <img v-else :src="image" :alt="name" > -->
  </div>
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      required: true
    },
    id: {
      type: String,
      required: true
    },
    video: {
      type: String,
      required: false,
      default: false
    },
    type: {
      type: String,
      default: 'youtube'
    },
    link: {
      type: String,
      required: true
    },
    image: {
      type: String,
      required: false,
      default: false
    }
  },

  data () {
    return {
      playerOptions: {
        techOrder: [this.type],
        muted: false,
        language: 'es',
        sources: [{ 'type': 'video/' + this.type, 'src': this.video }],
        poster: this.image,
        fluid: true
      }
    }
  }
}
</script>

<style lang="scss">

  .video-js {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 70% !important;
  }

.video-js .vjs-big-play-button {
    position: absolute;
    top: 40%;
    bottom: inherit;
    left: inherit;
    right: inherit;
}
.vimeoFrame {
position: absolute !important;
top: 0;
}
.no-video .vjs-poster{
  cursor: inherit;
}
</style>
