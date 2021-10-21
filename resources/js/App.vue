<template>
  <div class="container">

    <div class="my-2">
      <i class="fa fa-cog fa-spin" style="font-size:24px"></i>
      <span class="text-secondary m-0 h2">Plataforma ERP  |  Grupo Cofen</span>
    </div>

    <!-- https://github.com/vouill/vue-slideout -->

    <sidebar-menu
      class="justify-content-center"
      :menu="menu"
      :collapsed="true"
      :width='"180px"'
      :widthCollapsed='"50px"'
      @item-click="onItemClick"
    >
      <div class="bg-light text-center" slot="header">
        <img class="" src="logo___.png" width="50px">
      </div>
      <span slot="toggle-icon">
        <i class="fa fa-arrows-h"></i>
      </span>
    </sidebar-menu>

    <router-view class="bg-white p-3 mb-5 border rounded" ></router-view>

  </div>
</template>

<script>
  export default {
    data() {
      return {
        menu: [
          {
            href: '/home',
            title: 'Dashboard',
            icon: 'fa fa-bar-chart',
          },
          {
            href: '/providers',
            title: 'Validacion',
            icon: 'fa fa-truck',
            child: [
              {
                href: '/providers',
                title: 'Lineas',
              },
              {
                href: '/provider/truck',
                title: 'Unidades',
              },
              {
                href: '/provider/towing',
                title: 'Remolques',
              },
              {
                href: '/provider/operator',
                title: 'Operadores',
              },
            ],
          },
          {
            href: '/clients',
            title: 'Clientes',
            icon: 'fa fa-user-circle-o',
            child: [
              {
                href: '/clients',
                title: 'Clientes',
              },
              {
                href: '/clients/billing',
                title: 'Facturacion',
              },
              {
                href: '/clients/collect',
                title: 'Cobranza',
              },
              {
                href: '/clients/quotation',
                title: 'Cotizaciones',
              },
              {
                href: '/clients/contact',
                title: 'Contactos',
              },
            ],
          },
          {
            href: '/internalAudit',
            title: 'Auditoría',
            icon: 'fas fa-search-location',
          },
          {
            href: '/traffic',
            title: 'Tráfico',
            icon: 'fas fa-traffic-light',
            child: [
              {
                href: '/activeProviders',
                title: 'Proveedores',
              },
            ],
          },
          {
            href: '/logistic',
            title: 'Logistica',
            icon: 'fas fa-boxes',
          },
          {
            href: '/remissions',
            title: 'Remisiones',
            icon: 'fas fa-receipt',
          },
          {
            href: '/billing',
            title: 'Facturación',
            icon: 'fas fa-file-invoice-dollar',
          },
          {
            href: '/analytics',
            title: 'Analítica',
            icon: 'fa fa-cog',
            child: [
              {
                href: '/charts/sublink',
                title: 'Barra',
              },
              {
                href: '/charts/sublink',
                title: 'Pastel',
              },
              {
                href: '/charts/sublink',
                title: 'Area',
              }
            ],
          },
          {
            href: 'logout',
            title: 'Cerrar Sesion',
            icon: 'fas fa-sign-out-alt',
          },
        ],
      }
    },
    methods: {
        onItemClick(event, item, node) {
          if (item.href == 'logout') {
              window.location.href='/logout'
          }
        }
    },
  }
</script>