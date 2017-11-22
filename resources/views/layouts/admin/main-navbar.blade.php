<main-navbar inline-template :title="'{{ config('app.name') }}'" ref="main-navbar">
  <b-navbar v-cloak toggleable="md" type="dark" variant="primary">
    <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
    {{--
      <router-link >
        <span class="navbar-title-icon d-none d-md-inline"></span>
        <span class="navbar-title-label" v-text="pageTitle"></span>
      </router-link>
    --}}
    <b-navbar-brand :to="{ name:'home' }"><i class="icon-cog"></i> {{ config('app.name') }}</b-navbar-brand>

    <b-collapse is-nav id="nav_collapse">

      <b-navbar-nav>
        <nav-item
          v-for="(link, index) in main_nav_items"
          :link="link"
          :index="index"
          :key="index"></nav-item>
      </b-navbar-nav>

      <b-navbar-nav class="ml-auto">

        <b-nav-item-dropdown right>
          <!-- Using button-content slot -->
          <template slot="button-content">
            <em>{{ auth()->user()->name }}</em>
          </template>

          <b-dropdown-item exact :to="{ name: 'account.index' }">
            <i class="icon-user"></i> Mi cuenta
          </b-dropdown-item>

          <b-dropdown-divider></b-dropdown-divider>

          <b-dropdown-item exact :to="{ name: 'account.edit' }">
            <i class="icon-pencil"></i>
            Editar mi cuenta
          </b-dropdown-item>

          <b-dropdown-item exact :to="{ name: 'account.password' }">
            <i class="icon-key"></i>
            Actualizar contraseña
          </b-dropdown-item>

          @if(
            auth()->user()->policyCan('index', \App\Models\Role::class)
            || auth()->user()->policyCan('index', \App\User::class))
          <div class="dropdown-divider"></div>
          @endif

          @if(auth()->user()->policyCan('index', \App\Models\Role::class))
          <b-dropdown-item exact :to="{ name: 'roles.index' }">
            <i class="icon-lock"></i>
            Grupos y permisos
          </b-dropdown-item>
          @endif
          @if(auth()->user()->policyCan('index', \App\User::class))
          <b-dropdown-item exact :to="{ name: 'users.index' }">
            <i class="icon-user"></i>
            Usuarios del sistema
          </b-dropdown-item>
          @endif

          <b-dropdown-divider></b-dropdown-divider>

          <b-dropdown-item @click.prevent="logout">
            <i class="icon-exit"></i> Salir
          </b-dropdown-item >
        </b-nav-item-dropdown>
      </b-navbar-nav>

    </b-collapse>
  </b-navbar>
</main-navbar>