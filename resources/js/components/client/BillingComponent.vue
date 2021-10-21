<template>
	<div class="container">

		<div v-if="showList">
			<div class="row my-3">
      	<div class="col-7 align-self-center">
        	<h4>Lista de Facturacion</h4>
      	</div>

      	<div v-if="noClient" class="col-6 align-self-center">
        	<select
          	class="form-control"
          	v-model='billing.client_id'
          	@click="getBillings"
        	>
          	<option value selected disabled>Elegir un Cliente</option>
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
            <th>Tipo de Persona</th>
            <th>Telefono del Operador</th>
            <th>Direccion</th>
            <th>Ciudad Origen</th>
            <th class="text-center">Opciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="billing in billings" :key="billing.id">
            <td class="py-0">{{ billing.kind_person }}</td>
            <td class="py-0">{{ billing.payment_way }}</td>
            <td class="py-0">{{ billing.payment_method }}</td>
            <td class="py-0">{{ billing.monthly_closure }}</td>
            <td class="py-0 text-center">
              <div class="btn-group" role="group">
                <button
                  class="btn btn-light text-muted"
                  @click="switchForm(billing.id)"
                  ><i class="fa fa-edit"></i>
                </button>
                <button
                  class="btn btn-light text-danger"
                  @click="deleteBilling(billing.id)"
                  ><i class="fa fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

		<div class="row pt-3" v-else>
      <div class="form-group col-4">
        <label class="m-0">Tipo de Persona:</label>
        <select
          class="form-control"
          v-model='billing.kind_person'
        >
          <option value selected disabled>Elegir tipo de persona</option>
          <option>Fisica</option>
          <option>Moral</option>
          <option>Indefinido</option>
        </select>
      </div>

      <div class="form-group col-4">
        <label class="m-0">Forma de Pago:</label>
        <select
          class="form-control"
          v-model='billing.payment_way'
        >
          <option value selected disabled>Elegir forma de pago</option>
          <option>Efectivo</option>
          <option>Credito</option>
          <option>Transferencia</option>
        </select>
      </div>

      <div class="form-group col-4">
        <label class="m-0">Metodo de Pago:</label>
        <select
          class="form-control"
          v-model='billing.payment_method'
        >
          <option value selected disabled>Elegir metodo de pago</option>
          <option>Contado</option>
        </select>
      </div>

      <div class="form-group col-4">
        <label class="m-0">Uso CFDI:</label>
        <select
          class="form-control"
          v-model='billing.use_cfdi'
        >
          <option value selected disabled>Elegir CFDI</option>
          <option>Si</option>
          <option>No</option>
        </select>
      </div>

      <div class="form-group col-4">
        <label class="m-0">Cierre del Mes:</label>
        <select
          class="form-control"
          v-model='billing.monthly_closure'
        >
          <option value selected disabled>Elegir cierre de mes</option>
          <option>Septiembre</option>
          <option>Octubre</option>
          <option>Noviembre</option>
          <option>Diciembre</option>
        </select>
      </div>

      <div class="w-100"></div>

			<div class="form-group col-3">
				<input
          type="checkbox"
					class="form-check-control"
					v-model='billing.freight_retention_check'
				>
				<label class="m-0">Fletes con Retencion</label>
			</div>

      <div class="form-group col-3">
        <input
          type="checkbox"
          class="form-check-control"
          v-model='billing.discharge_retention_check'
        >
        <label class="m-0">Descarga con Retencion</label>
      </div>

      <div class="form-group col-3">
        <input
          type="checkbox"
          class="form-check-control"
          v-model='billing.maneuvers_retention_check'
        >
        <label class="m-0">Maniobras con Retencion</label>
      </div>

      <div class="form-group col-3">
        <input
          type="checkbox"
          class="form-check-control"
          v-model='billing.distributions_retention_check'
        >
        <label class="m-0">Repartos con Retencion</label>
      </div>

      <div class="form-group col-12">
        <fieldset class="border border-secondary rounded row">

          <legend class="w-auto">Recepcion de Evidencias</legend>

          <div class="form-group col-6">
            <label class="m-0">Recepcion de Evidencias:</label>
            <select
              class="form-control"
              v-model='billing.evidence_reception'
            >
              <option value selected disabled>Elegir recepcion de evidencias</option>
              <option>Fisica</option>
              <option>Moral</option>
              <option>Indefinido</option>
            </select>
          </div>

          <div class="form-group col-6">
            <label class="m-0">Direccion Recepcion Evidencias:</label>
            <input
              class="form-control"
              placeholder="Ingresar direccion de recepcion de evidencias"
              v-model='billing.evidence_reception_address'
            >
          </div>

          <div class="form-group col-6">
            <label class="m-0">Dias de Entrega:</label>
            <select
              class="form-control"
              v-model='billing.delivery_days'
            >
              <option value selected disabled>Elegir dias de entrega</option>
              <option>1 Dia(s)</option>
              <option>2 Dia(s)</option>
              <option>3 Dia(s)</option>
              <option>4 Dia(s)</option>
              <option>5 Dia(s)</option>
            </select>
          </div>

          <div class="form-group col-6">
            <label class="m-0">Correo Facturacion:</label>
            <input
              class="form-control"
              placeholder="Ingresar correo de facturacion"
              v-model='billing.email'
            >
          </div>

        </fieldset>
      </div>

      <div class="form-group col-12">
        <fieldset class="border border-secondary rounded row">

          <legend class="w-auto">Portal de Facturacion</legend>

          <div class="form-group col-4">
            <label class="m-0">Portal Facturacion:</label>
            <input
              class="form-control"
              placeholder="Ingresar portal de facturacion"
              v-model='billing.site'
            >
          </div>

          <div class="form-group col-4">
            <label class="m-0">Usuario Facturacion:</label>
            <input
              class="form-control"
              placeholder="Ingresar usuario de facturacion"
              v-model='billing.user'
            >
          </div>

          <div class="form-group col-4">
            <label class="m-0">Contraseña Facturacion:</label>
            <input
              class="form-control"
              placeholder="Ingresar contraseña de facturacion"
              v-model='billing.password'
            >
          </div>

        </fieldset>
      </div>

      <div class="form-group col-3">
        <label class="m-0">INE:</label>
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="customFileLang" lang="es">
          <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
        </div>
      </div>

			<div class="col-12 text-right">
				<button
					@click="wBilling"
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
		name: 'BillingComponent',
		data() {
		  return {
				showList: true,
        noClient: false,
			  billings: {},
			  billing: {
          client_id: '',
					kind_person: '',
          payment_way: '',
          payment_method: '',
          use_cfdi: '',
          monthly_closure: '',
          evidence_reception: '',
          delivery_days: '',
          distributions_retention_check: false,
          maneuvers_retention_check: false,
          discharge_retention_check: false,
          freight_retention_check: false,
        },
        clients: {},
		  }
		},
		mounted() {
			console.log(this.$options.name)
      if (this.$route.params.el) {
        this.setClient()
        this.getBillings()
      } else {
        this.noClient = true;
        this.getClients()
      }
		},
		methods: {
      setClient() {
        this.billing.client_id = this.$route.params.el.id
      },
			switchForm(id=null) {
        this.billing      = this.$options.data().billing
        this.showList     = !this.showList
        this.idBilling    = id
        if (id) this.getBilling()
      },
      getBillings() {
        this.axios
          .get(`${API_URL} ${this.billing.client_id}/getBillings`)
          .then(resp => {
            this.billings = resp.data
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
			getBilling() {
				this.axios
					.get(`${API_URL}client/billing/${this.idBilling}`)
					.then(resp => {
						if (resp.data) {
							this.billing = resp.data
						}
					})
					.catch(err => console.log(err))
					.finally(() => this.loading = false)
			},
      wBilling() {
        this.setClient()
        if (this.billing.id) {
          this.editBilling()
        }else{
          this.addBilling()
        }
        this.getBillings()
      },
			addBilling() {
				this.axios
					.post(API_URL + 'client/billing', this.billing)
					.then(resp => {
            this.switchForm()
					})
					.catch(err => console.log(err))
					.finally(() => this.loading = false)
			},
      editBilling() {
        this.axios
          .patch(`${API_URL}client/billing/${this.billing.id}`, this.billing)
          .then(resp => (
            this.switchForm()
          ))
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      deleteBilling(id) {
        this.axios
          .delete(`${API_URL}client/billing/${id}`)
          .then(resp => {
            if (resp.data) {
              let i = this.billings.map(item => item.id).indexOf(id);
              this.billings.splice(i, 1)
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
  legend {
    font-size: 1rem;
    margin-left: 10px;
    margin-right: 10px;
  }
  $custom-file-text: (
    en: "Browse",
    es: "Elegir"
  );
</style>