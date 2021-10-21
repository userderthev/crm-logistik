<template>
  <div class="container">

    <h3 class="text-center">Modulo de Proveedores Activos</h3>
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th>Nombre de Linea</th>
          <th class="text-center">RFC</th>
          <th>Nombre Propietario</th>
          <th>Telefono Propietario</th>
          <th>Nombre Coordinador</th>
          <th class="text-center">Status</th>
          <th class="text-center">Opciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="provider in providers" :key="provider.id">
          <td class="py-1">{{ provider.name }}</td>
          <td class="py-1">{{ provider.rfc }}</td>
          <td class="py-1">{{ provider.owner }}</td>
          <td class="py-1">{{ provider.owner_phone }}</td>
          <td class="py-1">{{ provider.coordinator }}</td>
          <td class="py-1 text-center text-md">
            <span v-if="provider.status_id == 1" class="badge badge-primary">Pendiente</span>
            <span v-else-if="provider.status_id == 2" class="badge badge-warning">Revision</span>
            <span v-else-if="provider.status_id == 3" class="badge badge-danger">Rechazado</span>
            <span v-else-if="provider.status_id == 4" class="badge badge-success">Aprovado</span>
            <span v-else class="badge badge-secondary">Inhabilitado</span>
          </td>
          <td class="text-center">
            <div class="btn-group" role="group">
              <div class="py-1">
                <router-link
                  class="py-1"
                  :to="{name: 'editProvider', params: { el: provider, onReadOnly: true }}"
                >
                <i
                  data-toggle="tooltip"
                  data-placement="top"
                  title="Mostrar"
                  class="fa fa-eye text-secondary handle"
                ></i>
                </router-link>
                <i
                  data-toggle="tooltip"
                  data-placement="top"
                  title="Deshabilitar"
                  class="fa fa-ban text-secondary handle"
                  @click="disabledProviderModal(provider)"
                ></i>
              </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="disabledProviderModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
            </button>
            <h5 class="modal-title">
              ¿Estas seguro que deseas deshabilitar este proveedor?
            </h5>
          </div>
          <div class="modal-footer">
            <button
              class="btn"
              data-dismiss="modal"
              >Cancelar
            </button>
            <button
              class="btn btn-secondary"
              @click="disabledProvider"
              >Deshabilitar
            </button>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
  export default {
    name: 'ProviderComponent',
    data() {
      return {
        providers: {},
        provider: {},
        status: {
          approve: 4,
          disabled: 5,
        },
      }
    },
    mounted() {
      console.log(this.$options.name)
      this.getProviders()
    },
    methods: {
      getProviders() {
        this.axios
          .get(API_URL + 'auditProviders/' + this.status.approve)
          .then(resp => {
            this.providers = resp.data
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      disabledProviderModal(provider) {
        this.provider = provider
        $('#disabledProviderModal').modal('show')
      },
      disabledProvider() {
        this.provider.status = this.provider.status_id = this.status.disabled
        this.axios
          .post(`${API_URL}setStatusLine`, this.provider)
          .then(resp => {
            $('#disabledProviderModal').modal('hide')
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
    },
  }
</script>

<style scoped>
  td {
    padding-top: 0px;
    padding-bottom: 0px;
  }
  .handle {
    cursor: pointer;
  }
</style>
