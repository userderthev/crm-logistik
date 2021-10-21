<template>
	<div class="container">

		<div v-if="showList">
			<div class="row my-3">
      	<div class="col-7 align-self-center">
        	<h4>Lista de Clientes</h4>
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
            <th>Nombre del Operador</th>
            <th>Telefono del Operador</th>
            <th>Direccion</th>
            <th>Ciudad Origen</th>
            <th class="text-center">Opciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="operator in operators" :key="operator.id">
            <td class="py-0">{{ operator.name }}</td>
            <td class="py-0">{{ operator.phone }}</td>
            <td class="py-0">{{ operator.address }}</td>
            <td class="py-0">{{ operator.city_origin }}</td>
            <td class="py-0 text-center">
              <div class="btn-group" role="group">
                <button
                  class="btn btn-light text-muted"
                  @click="switchForm(operator.id)"
                  ><i class="fa fa-edit"></i>
                </button>
                <button
                  class="btn btn-light text-danger"
                  @click="deleteClient(operator.id)"
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
				<label class="m-0">Razon Social:</label>
				<input
					class="form-control"
					placeholder="Ingresar nombre del cliente"
					v-model='client.name'
				>
			</div>
			<div class="form-group col-3">
				<label class="m-0">RFC:</label>
				<input
					class="form-control"
					placeholder="Ingresar rfc"
					v-model='client.rfc'
				>
			</div>
			<div class="form-group col-3">
				<label class="m-0">Telefono:</label>
				<input
					class="form-control"
					placeholder="Ingresar telefono"
					v-model='client.phone'
				>
			</div>

			<div class="form-group col-9">
				<label class="m-0">Direccion:</label>
				<input
					class="form-control"
					placeholder="Ingresar la direccion"
					v-model='client.address'
				>
			</div>
			<div class="form-group col-3">
				<label class="m-0">Tipo de Empresa:</label>
				<select
					class="form-control"
					v-model='client.company_type'
				>
					<option value="" selected disabled>Elegir una ciudad</option>
					<option>Micro</option>
					<option>Pequeña</option>
					<option>Mediana</option>
					<option>Grande</option>
				</select>
			</div>

			<div class="form-group col-4">
				<label class="m-0">Pagina Web:</label>
				<input
					class="form-control"
					placeholder="Ingresar fecha de creacion"
					v-model='client.web_page'
				>
			</div>

			<div class="col-12 text-right">
				<button
					@click="wClient"
					class="btn btn-success text-center"
					><i class="fa fa fa-floppy-o"></i> Guardar
				</button>
				<router-link
					to="/clients"
					class="btn btn-danger"
          ><i class="fa fa-times"></i> Cancelar
				</router-link>
			</div>
		</div>

	</div>
</template>

<script>
	export default {
		name: 'ClientComponent',
		data() {
		  return {
				showList: false,
			  clients: {},
			  client: {
					company_type: '',
			  },
        noClient: false,
		  }
		},
		mounted() {
			console.log(this.$options.name)
      if (this.$route.params.el) {
        this.client = this.$route.params.el
        this.getClients()
      } else {
        this.noClient = true;
        this.getClients()
      }
		},
		methods: {
			switchForm(id=null) {
        this.client      = this.$options.data().client
        // this.showList     = !this.showList
        this.idClient    = id
        if (id) this.getOperator()
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
			getOperator() {
				this.axios
					.get(`${API_URL}client/${this.client.id}`)
					.then(resp => {
						if (resp.data) {
							this.operator = resp.data
						}
					})
					.catch(err => console.log(err))
					.finally(() => this.loading = false)
			},
      wClient() {
        if (this.client.id) {
          this.editClient()
        }else{
          this.addClient()
        }
        this.$router.push({name: 'clients'})
      },
			addClient() {
				this.axios
					.post(API_URL + 'client', this.client)
					.then(resp => {
            this.switchForm()
					})
					.catch(err => console.log(err))
					.finally(() => this.loading = false)
			},
      editClient() {
        this.axios
          .patch(`${API_URL}client/${this.client.id}`, this.client)
          .then(resp => (
            this.switchForm()
          ))
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      deleteClient(id) {
        this.axios
          .delete(`${API_URL}client/${id}`)
          .then(resp => {
            if (resp.data) {
              let i = this.clients.map(item => item.id).indexOf(id);
              this.clients.splice(i, 1)
            }
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
		}
	}
</script>
