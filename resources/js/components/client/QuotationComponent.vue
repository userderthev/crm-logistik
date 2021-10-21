<template>
	<div class="container">

		<div v-if="showList">
			<div class="row my-3">
      	<div class="col-7 align-self-center">
        	<h4>Lista de Cotizaciones</h4>
      	</div>

      	<div v-if="noClient" class="col-6 align-self-center">
        	<select
          	class="form-control"
          	v-model='quotation.client_id'
          	@click="getQuotations"
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
            <th>Tipo de Unidad</th>
            <th>Tipo de Remolque</th>
            <th>Tarifa</th>
            <th>Ciudad Origen</th>
            <th>Ciudad Destino</th>
            <th class="text-center">Opciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="quotation in quotations" :key="quotation.id">
            <td class="py-0">{{ quotation.truck_type }}</td>
            <td class="py-0">{{ quotation.towing_type }}</td>
            <td class="py-0">{{ quotation.rate }}</td>
            <td class="py-0">{{ quotation.origin_city }}</td>
            <td class="py-0">{{ quotation.target_city }}</td>
            <td class="py-0 text-center">
              <div class="btn-group" role="group">
                <button
                  class="btn btn-light text-muted"
                  @click="switchForm(quotation.id)"
                  ><i class="fa fa-edit"></i>
                </button>
                <button
                  class="btn btn-light text-danger"
                  @click="deleteQuotation(quotation.id)"
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
        <label class="m-0">Tipo de Unidad:</label>
        <select
          class="form-control"
          v-model='quotation.truck_type'
        >
          <option value="" selected disabled>Elegir tipo de unidad</option>
          <option>Banorte</option>
          <option>Banregio</option>
          <option>Afirme</option>
        </select>
      </div>

      <div class="form-group col-4">
        <label class="m-0">Tipo de Remolque:</label>
        <select
          class="form-control"
          v-model='quotation.towing_type'
        >
          <option value="" selected disabled>Elegir tipo de remolque</option>
          <option>Banorte</option>
          <option>Banregio</option>
          <option>Afirme</option>
        </select>
      </div>

      <div class="form-group col-4">
        <label class="m-0">Tarifa:</label>
        <select
          class="form-control"
          v-model='quotation.rate'
        >
          <option value="" selected disabled>Elegir una tarifa</option>
          <option>Banorte</option>
          <option>Banregio</option>
          <option>Afirme</option>
        </select>
      </div>

      <div class="form-group col-6">
        <label class="m-0">Origen:</label>
        <select
          class="form-control"
          v-model='quotation.origin_city'
        >
          <option value="" selected disabled>Elegir origen</option>
          <option>Banorte</option>
          <option>Banregio</option>
          <option>Afirme</option>
        </select>
      </div>

      <div class="form-group col-6">
        <label class="m-0">Destino:</label>
        <select
          class="form-control"
          v-model='quotation.target_city'
        >
          <option value="" selected disabled>Elegir destino</option>
          <option>Banorte</option>
          <option>Banregio</option>
          <option>Afirme</option>
        </select>
      </div>

      <div class="form-group col-12">

        <fieldset class="border border-secondary rounded row">

          <legend class="w-auto">Requisitos del Operador</legend>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.epp_check'
            >
            <label class="m-0">EPP</label>
          </div>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.imss_check'
            >
            <label class="m-0">IMSS</label>
          </div>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.client_app_check'
            >
            <label class="m-0">Aplicacion Cliente</label>
          </div>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.imss_payment_check'
            >
            <label class="m-0">Ultimo Pago IMSS</label>
          </div>

        </fieldset>
      </div>

      <div class="form-group col-12">

        <fieldset class="border border-secondary rounded row">

          <legend class="w-auto">Requisitos de Unidad</legend>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.insurance_check'
            >
            <label class="m-0">Seguro Unidad</label>
          </div>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.mirror_account_check'
            >
            <label class="m-0">Cuenta Espejo</label>
          </div>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.reverse_alarm_check'
            >
            <label class="m-0">Alarma Reversa</label>
          </div>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.gps_check'
            >
            <label class="m-0">Contrato GPS</label>
          </div>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.hydraulic_ramp_check'
            >
            <label class="m-0">Rampa Hidraulica</label>
          </div>

        </fieldset>
      </div>

      <div class="form-group col-12">

        <fieldset class="border border-secondary rounded row">

          <legend class="w-auto">Requisitos del Remolque</legend>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.no_odor_check'
            >
            <label class="m-0">Sin Olores</label>
          </div>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.wooden_floor_check'
            >
            <label class="m-0">Piso de Madera</label>
          </div>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.no_spillage_check'
            >
            <label class="m-0">Sin Derrames</label>
          </div>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.oversize_check'
            >
            <label class="m-0">Sobredimension</label>
          </div>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.hermetic_door_check'
            >
            <label class="m-0">Puerta Hermetica</label>
          </div>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.no_filtration_check'
            >
            <label class="m-0">Sin Filtracion</label>
          </div>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.fumigation_check'
            >
            <label class="m-0">Certificado Fumigacion</label>
          </div>

        </fieldset>
      </div>

      <div class="form-group col-12">
        <fieldset class="border border-secondary rounded row">

          <legend class="w-auto">Equipo de Sujetacion</legend>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.bands_check'
            >
            <label class="m-0">Bandas</label>
          </div>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.jacks_check'
            >
            <label class="m-0">Gatas</label>
          </div>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.chains_check'
            >
            <label class="m-0">Cadenas</label>
          </div>

          <div class="form-group col-3">
            <input
              type="checkbox"
              class="form-check-control"
              v-model='quotation.rails_check'
            >
            <label class="m-0">Rieles Logisticos</label>
          </div>

        </fieldset>
      </div>

			<div class="col-12 text-right">
				<button
					@click="wQuotation"
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
		name: 'QuotationComponent',
		data() {
		  return {
				showList: true,
        noClient: false,
			  quotations: {},
			  quotation: {
          client_id: '',
					truck_type: '',
          towing_type: '',
          rate: '',
          origin_city: '',
          target_city: '',
          epp_check: false,
          imss_check: false,
          client_app_check: false,
          imss_payment_check: false,
          insurance_check: false,
          mirror_account_check: false,
          reverse_alarm_check: false,
          gps_check: false,
          hydraulic_ramp_check: false,
          no_odor_check: false,
          wooden_floor_check: false,
          no_spillage_check: false,
          oversize_check: false,
          hermetic_door_check: false,
          no_filtration_check: false,
          fumigation_check: false,
          bands_check: false,
          jacks_check: false,
          chains_check: false,
          rails_check: false,
			  },
        clients: {},
		  }
		},
		mounted() {
			console.log(this.$options.name)
      if (this.$route.params.el) {
        this.setClient()
        this.getQuotations()
      } else {
        this.noClient = true;
        this.getClients()
      }
		},
		methods: {
      setClient() {
        this.quotation.client_id = this.$route.params.el.id
      },
			switchForm(id=null) {
        this.quotation      = this.$options.data().quotation
        this.showList     = !this.showList
        this.idQuotation    = id
        if (id) this.getQuotation()
      },
      getQuotations() {
        this.axios
          .get(`${API_URL}${this.quotation.client_id}/getQuotations`)
          .then(resp => {
            this.quotations = resp.data
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
			getQuotation() {
				this.axios
					.get(`${API_URL}client/quotation/${this.idQuotation}`)
					.then(resp => {
						if (resp.data) {
							this.quotation = resp.data
						}
					})
					.catch(err => console.log(err))
					.finally(() => this.loading = false)
			},
      wQuotation() {
        this.setClient()
        if (this.quotation.id) {
          this.editQuotation()
        }else{
          this.addQuotation()
        }
        this.getQuotations()
      },
			addQuotation() {
				this.axios
					.post(API_URL + 'client/quotation', this.quotation)
					.then(resp => {
            this.switchForm()
					})
					.catch(err => console.log(err))
					.finally(() => this.loading = false)
			},
      editQuotation() {
        this.axios
          .patch(`${API_URL}client/quotation/${this.quotation.id}`, this.quotation)
          .then(resp => (
            this.switchForm()
          ))
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      deleteQuotation(id) {
        this.axios
          .delete(`${API_URL}client/quotation/${id}`)
          .then(resp => {
            if (resp.data) {
              let i = this.quotations.map(item => item.id).indexOf(id);
              this.quotations.splice(i, 1)
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
</style>