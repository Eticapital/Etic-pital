<side-navbar inline-template id="side-nav">
  <nav id="side-nav" class="navbar d-block">
    <div class="navbar-side-title d-block d-lg-none"> <!-- o navbar-side-title-img  para usar una imagen-->
      <router-link :to="{ name:'home' }" class="d-flex align-items-center">
        <span class="navbar-title-icon"><i class="icon-cog"></i></span>
        <span class="navbar-title-label" v-text="pageTitle"></span>
      </router-link>
    </div>
    <vue-perfect-scrollbar ref="SideNavScroll">
      <ul class="navbar-nav navbar-side">
        <side-nav-item
          v-for="(link, index) in nav_items"
          v-if="!link.hide"
          :link="link"
          :index="index"
          :element-name="'main-nav'"
          :key="index"
        ></side-nav-item>
      </ul>
    </vue-perfect-scrollbar>
  </nav>
</side-navbar>