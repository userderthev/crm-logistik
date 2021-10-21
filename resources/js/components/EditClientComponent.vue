<template>
  <div class="container">
    <div class="row">
      <h3 class="text-center col">Editar Clientes</h3>
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
          <li class="nav-item">
            <a
              class="nav-link"
              id="reference-tab"
              data-toggle="tab"
              href="#billing"
              role="tab"
              >Facturación
            </a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              id="reference-tab"
              data-toggle="tab"
              href="#collects"
              role="tab"
              >Cobranza
            </a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              id="reference-tab"
              data-toggle="tab"
              href="#quotations"
              role="tab"
              >Cotizaciones
            </a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              id="reference-tab"
              data-toggle="tab"
              href="#contacts"
              role="tab"
              >Contactos
            </a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="clients" role="tabpanel">
            <ClientComponent/>
          </div>
          <div class="tab-pane fade" id="billing" role="tabpanel">
            <BillingComponent/>
          </div>
          <div class="tab-pane fade" id="collects" role="tabpanel">
            <CollectComponent/>
          </div>
          <div class="tab-pane fade" id="quotations" role="tabpanel">
            <QuotationComponent/>
          </div>
          <div class="tab-pane fade" id="contacts" role="tabpanel">
            <ContactComponent/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import ClientComponent from "./client/ClientComponent.vue";
  import BillingComponent from "./client/BillingComponent.vue";
  import CollectComponent from "./client/CollectComponent.vue";
  import QuotationComponent from "./client/QuotationComponent.vue";
  import ContactComponent from "./client/ContactComponent.vue";

  export default {
    name: 'EditClientComponent',
    components: {
      BillingComponent,
      ClientComponent,
      CollectComponent,
      QuotationComponent,
      ContactComponent,
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
