<template>
  <div class="container">
    <div class="row">
      <h3 class="text-center col">Agregar Proveedores</h3>
      <div class="col-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a
              class="nav-link active"
              id="line-tab"
              data-toggle="tab"
              href="#line"
              role="tab"
              >Lineas
            </a>
          </li>
          <li v-if="false" class="nav-item">
            <a
              class="nav-link"
              id="reference-tab"
              data-toggle="tab"
              href="#reference"
              role="tab"
              >Referencias
            </a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="line" role="tabpanel">
            <AddLineComponent/>
          </div>
          <div v-if="false" class="tab-pane fade" id="reference" role="tabpanel">
            <ReferenceComponent/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import AddLineComponent from "./AddLineComponent.vue";
  import ReferenceComponent from "./ReferenceComponent.vue";

  export default {
    name: 'AddProviderComponent',
    components: {
      AddLineComponent,
      ReferenceComponent,
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
