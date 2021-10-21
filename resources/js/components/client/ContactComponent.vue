<template>
	<div class="container">

		<div v-if="showList">
			<div class="row my-3">
      	<div class="col-7 align-self-center">
        	<h4>Lista de Contactos</h4>
      	</div>

      	<div v-if="noClient" class="col-6 align-self-center">
        	<select
          	class="form-control"
          	v-model='contact.client_id'
          	@click="getContacts"
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
            <th>Nombre del Contacto</th>
            <th>Cargo</th>
            <th>Telefono</th>
            <th>Correo Electronico</th>
            <th class="text-center">Opciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="contact in contacts" :key="contact.id">
            <td class="py-0">{{ contact.name }}</td>
            <td class="py-0">{{ contact.position }}</td>
            <td class="py-0">{{ contact.phone }}</td>
            <td class="py-0">{{ contact.email }}</td>
            <td class="py-0 text-center">
              <div class="btn-group" role="group">
                <button
                  class="btn btn-light text-muted"
                  @click="switchForm(contact.id)"
                  ><i class="fa fa-edit"></i>
                </button>
                <button
                  class="btn btn-light text-danger"
                  @click="deleteContact(contact.id)"
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
        <label class="m-0">Nombre del Contacto:</label>
        <input
          class="form-control"
          placeholder="Ingresar nombre del contacto"
          v-model='contact.name'
        >
      </div>

      <div class="form-group col-6">
        <label class="m-0">Puesto del Contacto:</label>
        <select
          class="form-control"
          v-model='contact.position'
        >
          <option value="" selected disabled>Elegir un puesto</option>
          <option>Director</option>
          <option>Gerente</option>
          <option>Supervisor</option>
          <option>Administrativo</option>
          <option>Operario</option>
        </select>
      </div>

      <div class="form-group col-6">
        <label class="m-0">Telefono:</label>
        <input
          class="form-control"
          placeholder="Ingresar telefono del contacto"
          v-model='contact.phone'
        >
      </div>

      <div class="form-group col-6">
        <label class="m-0">Correo:</label>
        <input
          class="form-control"
          placeholder="Ingresar correo del contacto"
          v-model='contact.email'
        >
      </div>

			<div class="col-12 text-right">
				<button
					@click="wContact"
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
	export default {
		name: 'ContactComponent',
		data() {
		  return {
				showList: true,
        noClient: false,
			  contacts: {},
			  contact: {
          client_id: '',
					position: '',
			  },
        clients: {},
		  }
		},
		mounted() {
			console.log(this.$options.name)
      if (this.$route.params.el) {
        // MODULO HIJO
        this.setClient()
        this.getContacts()
      } else {
      	// MODULO PADRE
        this.noClient = true;
        this.getClients()
      }
		},
		methods: {
      setClient() {
        this.contact.client_id = this.$route.params.el.id
      },
			switchForm(id=null) {
        this.contact      = this.$options.data().contact
        this.showList     = !this.showList
        this.idContact    = id
        if (id) this.getContact()
      },
      getContacts() {
        this.axios
          .get(`${API_URL} ${this.contact.client_id}/getContacts`)
          .then(resp => {
            this.contacts = resp.data
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
			getContact() {
				this.axios
					.get(`${API_URL}client/contact/${this.idContact}`)
					.then(resp => {
						if (resp.data) {
							this.contact = resp.data
						}
					})
					.catch(err => console.log(err))
					.finally(() => this.loading = false)
			},
      wContact() {
        this.setClient()
        if (this.contact.id) {
          this.editContact()
        }else{
          this.addContact()
        }
        this.getContacts()
      },
			addContact() {
				this.axios
					.post(API_URL + 'client/contact', this.contact)
					.then(resp => {
            this.switchForm()
					})
					.catch(err => console.log(err))
					.finally(() => this.loading = false)
			},
      editContact() {
        this.axios
          .patch(`${API_URL}client/contact/${this.contact.id}`, this.contact)
          .then(resp => (
            this.switchForm()
          ))
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      deleteContact(id) {
        this.axios
          .delete(`${API_URL}client/contact/${id}`)
          .then(resp => {
            if (resp.data) {
              let i = this.contacts.map(item => item.id).indexOf(id);
              this.contacts.splice(i, 1)
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