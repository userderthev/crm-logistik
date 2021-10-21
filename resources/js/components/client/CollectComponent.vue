<template>
	<div class="container">

		<div v-if="showList">
			<div class="row my-3">
      	<div class="col-7 align-self-center">
        	<h4>Lista de Cobranza</h4>
      	</div>

      	<div v-if="noClient" class="col-6 align-self-center">
        	<select
          	class="form-control"
          	v-model='collect.client_id'
          	@click="getCollects"
        	>
          	<option value="" selected disabled>Elegir un Cliente</option>
          	<option v-for="client in clients" :value="client.id">{{client.name}}</option>
        	</select>
      	</div>

      	<div class="col text-right">
        	<button
          	@click="switchForm()"
          	class="btn btn-primary"
          	><i class="fa fa-plus-circle"></i> Agregar
        	</button>
        	<router-link
          	to="/clients"
          	class="btn btn-secondary"
          	><i class="fa fa-arrow-circle-left"></i> Cerrar
        	</router-link>
      	</div>
      </div>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nombre del Banco</th>
            <th>Portal de Pagos</th>
            <th>Numero de Cuenta</th>
            <th>Fecha de Alta</th>
            <th class="text-center">Opciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="collect in collects" :key="collect.id">
            <td class="py-0">{{ collect.bank }}</td>
            <td class="py-0">{{ collect.payment_site }}</td>
            <td class="py-0">{{ collect.account_number }}</td>
            <td class="py-0">{{ formatDate(collect.created_at) }}</td>
            <td class="py-0 text-center">
              <div class="btn-group" role="group">
                <button
                  class="btn btn-light text-muted"
                  @click="switchForm(collect.id)"
                  ><i class="fa fa-edit"></i>
                </button>
                <button
                  class="btn btn-light text-danger"
                  @click="deleteCollect(collect.id)"
                  ><i class="fa fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

		<div class="row pt-3" v-else>
      <div class="form-group col-6">
        <label class="m-0">Banco:</label>
        <select
          class="form-control"
          v-model='collect.bank'
        >
          <option value="" selected disabled>Elegir un banco</option>
          <option>Banorte</option>
          <option>Banregio</option>
          <option>Afirme</option>
        </select>
      </div>

      <div class="form-group col-6">
        <label class="m-0">Portal de Pagos:</label>
        <input
          class="form-control"
          placeholder="Ingresar portal de pagos"
          v-model='collect.payment_site'
        >
      </div>

      <div class="form-group col-6">
        <label class="m-0">Numero de Cuenta:</label>
        <input
          class="form-control"
          placeholder="Ingresar numero de cuenta"
          v-model='collect.account_number'
        >
      </div>

      <div class="form-group col-6">
        <label class="m-0">Password del Portal:</label>
        <input
          class="form-control"
          placeholder="Ingresar password del portal"
          v-model='collect.password_site'
        >
      </div>

			<div class="col-12 text-right">
				<button
					@click="wCollect"
					class="btn btn-success text-center"
					><i class="fa fa fa-floppy-o"></i> Guardar
				</button>
        <button
          @click="switchForm()"
          class="btn btn-danger"
          ><i class="fa fa-times"></i> Cancelar
        </button>
			</div>
		</div>

	</div>
</template>

<script>
  import moment from 'moment';

	export default {
		name: 'CollectComponent',
		data() {
		  return {
				showList: true,
        noClient: false,
			  collects: {},
			  collect: {
					client_id: '',
          bank: '',
			  },
        clients: {},
		  }
		},
		mounted() {
			console.log(this.$options.name)
      if (this.$route.params.el) {
        this.setClient()
        this.getCollects()
      } else {
        this.noClient = true;
        this.getClients()
      }
		},
		methods: {
      setClient() {
        this.collect.client_id = this.$route.params.el.id
      },
      formatDate(date) {
        return moment(date).format('MM/DD/YYYY hh:mm')
      },
			switchForm(id=null) {
        this.collect      = this.$options.data().collect
        this.showList     = !this.showList
        this.idCollect    = id
        if (id) this.getCollect()
      },
      getCollects() {
        this.axios
          .get(`${API_URL}${this.collect.client_id}/getCollects`)
          .then(resp => {
            this.collects = resp.data
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
			getCollect() {
				this.axios
					.get(`${API_URL}client/collect/${this.idCollect}`)
					.then(resp => {
						if (resp.data) {
							this.collect = resp.data
						}
					})
					.catch(err => console.log(err))
					.finally(() => this.loading = false)
			},
      wCollect() {
        this.setClient()
        if (this.collect.id) {
          this.editCollect()
        }else{
          this.addCollect()
        }
        this.getCollects()
      },
			addCollect() {
				this.axios
					.post(API_URL + 'client/collect', this.collect)
					.then(resp => {
            this.switchForm()
					})
					.catch(err => console.log(err))
					.finally(() => this.loading = false)
			},
      editCollect() {
        this.axios
          .patch(`${API_URL}client/collect/${this.collect.id}`, this.collect)
          .then(resp => (
            this.switchForm()
          ))
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      deleteCollect(id) {
        this.axios
          .delete(`${API_URL}client/collect/${id}`)
          .then(resp => {
            if (resp.data) {
              let i = this.collects.map(item => item.id).indexOf(id);
              this.collects.splice(i, 1)
            }
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
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
		}
	}
</script>

<style scoped>

</style>