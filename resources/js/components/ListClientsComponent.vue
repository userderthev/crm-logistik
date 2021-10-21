<template>
  <div class="container">
    <h3 class="text-center mb-0">Lista de Clientes</h3>
    <div class="col text-right p-0 mb-2">
      <router-link
        to="/addClient"
        class="btn btn-primary"
        ><i class="fa fa-plus-circle"></i> Agregar
      </router-link>
    </div>
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th>Razon Social</th>
          <th class="text-center">RFC</th>
          <th>Tipo de Empresa</th>
          <th>Telefono</th>
          <th>Pagina Web</th>
          <th class="text-center">Fecha de Alta</th>
          <th class="text-center">Opciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="client in clients" :key="client.id">
          <td class="py-1">{{ client.name }}</td>
          <td class="py-1">{{ client.rfc }}</td>
          <td class="py-1">{{ client.company_type }}</td>
          <td class="py-1">{{ client.phone }}</td>
          <td class="py-1">{{ client.web_page }}</td>
          <td class="py-1 text-center">{{ formatDate(client.created_at) }}</td>
          <td class="py-0 text-center">
            <div class="btn-group" role="group">
              <div class="py-1">
                <router-link
                  class="text-muted py-1"
                  :to="{name: 'editClient', params: { el: client }}"
                  ><i class="fa fa-edit"></i>
                </router-link>
                <i class="fa fa-trash text-danger handle" @click="deleteClient(client.id)"></i>
              </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  import moment from 'moment';

  export default {
    name: 'ListClientsComponent',
    data() {
      return {
        clients: {},
      }
    },
    mounted() {
      console.log(this.$options.name)
      this.getClients()
    },
    methods: {
      formatDate(date) {
        return moment(date).format('DD/MM/YYYY hh:mm')
      },
      getClients() {
        this.axios
          .get(API_URL + 'client')
          .then(resp => {
            this.clients = resp.data
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      deleteClient(id) {
        this.axios
          .delete(`${API_URL}client/${id}`)
          .then(response => {
            let i = this.clients.map(item => item.id).indexOf(id); // find index of your object
            this.clients.splice(i, 1)
          });
      }
    }
  }
</script>

<style scoped>
  .handle {
    cursor: pointer;
  }
</style>
