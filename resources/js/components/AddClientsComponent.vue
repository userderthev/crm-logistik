<template>
  <div class="container">
    <div class="row">
      <h3 class="text-center col">Agregar Clientes</h3>
      <div class="col-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a
              class="nav-link active"
              id="line-tab"
              data-toggle="tab"
              href="#clients"
              role="tab"
              >Clientes
            </a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="clients" role="tabpanel">
            <ClientComponent/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import ClientComponent from "./client/ClientComponent.vue";

  export default {
    name: 'AddClientsComponent',
    components: {
      ClientComponent,
    },
    data() {
      return {
      }
    },
    mounted() {
      console.log(this.$options.name)
    },
    methods: {
    }
  }
</script>
