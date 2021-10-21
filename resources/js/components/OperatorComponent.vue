<template>
	<div class="container">

		<div v-if="showList">

			<div class="row my-3">
      	<div class="col-7 align-self-center">
        	<h4>Lista de Operadores</h4>
      	</div>

      	<div v-if="hasProvider" class="col-6 align-self-center">
        	<select
          	class="form-control"
          	v-model='operator.provider_id'
          	@change="getOperators"
        	>
          	<option value="" selected disabled>Elegir un Proveedor</option>
          	<option v-for="provider in providers" :value="provider.id">{{provider.name}}</option>
        	</select>
      	</div>

      	<div class="col text-right">
        	<button
            v-show="!onReadOnly"
          	class="btn btn-primary"
          	@click="switchForm()"
          	><i class="fa fa-plus-circle"></i> Agregar
        	</button>
        	<router-link
            :to="onReadOnly ? '/activeProviders' : '/providers'"
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
            <th>Ciudad Origen</th>
            <th>Status</th>
            <th class="text-center">Opciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="operator in operators" :key="operator.id">
            <td class="py-0">{{ operator.name }}</td>
            <td class="py-0">{{ operator.phone }}</td>
            <td class="py-0">{{ operator.city ? operator.city.name : '' }}</td>
						<td class="py-1 text-center text-md">
            	<span v-if="operator.status_id == 1" class="badge badge-primary">Pendiente</span>
            	<span v-else-if="operator.status_id == 2" class="badge badge-warning">Revision</span>
            	<span v-else-if="operator.status_id == 3" class="badge badge-danger">Rechazado</span>
            	<span v-else-if="operator.status_id == 4" class="badge badge-success">Aprovado</span>
            	<span v-else class="badge badge-secondary">Inhabilitado</span>
						</td>
            <td class="py-0 text-center">
              <div class="btn-group" role="group" v-if="!onRevision && !onReadOnly">
                <button
                  class="btn btn-light text-primary"
                  @click="switchForm(operator.id,true)"
                  ><i class="fa fa-search"></i>
                </button>
                <button
                  class="btn btn-light text-muted"
                  @click="switchForm(operator.id,false)"
                  ><i class="fa fa-edit"></i>
                </button>
                <button
                  class="btn btn-light text-danger"
                  @click="deleteOperator(operator.id,false)"
                  ><i class="fa fa-trash"></i>
                </button>
              </div>
              <div class="btn-group" role="group" v-else>
                <button
                  class="btn btn-light text-muted"
                  @click="switchForm(operator.id,false)"
                  ><i class="fa fa-eye"></i>
                </button>
                <button
                  class="btn btn-light text-muted"
                  @click="setStatusModal(status.disabled,operator.id)"
                  ><i class="fa fa-ban"></i>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

    </div>

		<div class="row pt-3" v-else>
			<div class="form-group col-6">
				<label class="required m-0">Nombre del Operador:</label>
				<input
					required
					class="form-control"
					placeholder="Ingresar nombre del operador"
					v-model='operator.name'
				>
			</div>
			<div class="form-group col-3">
				<label class="m-0">Telefono del Operador:</label>
				<input
					class="form-control"
					placeholder="Ingresar telefono de operador"
					v-model='operator.phone'
				>
			</div>
			<div class="form-group col-3">
				<label class="m-0">Telefono de Casa:</label>
				<input
					class="form-control"
					placeholder="Ingresar telefono de casa"
					v-model='operator.home_phone'
				>
			</div>

			<div class="form-group col-8">
				<label class="m-0">Direccion:</label>
				<input
					class="form-control"
					placeholder="Ingresar la direccion"
					v-model='operator.address'
				>
			</div>
			<div class="form-group col-4">
				<label class="m-0">Ciudad Origen:</label>
				<select
					class="form-control"
					v-model='operator.city_id'
				>
          <option value selected disabled>Elegir ciudad origen</option>
          <option
          	v-for='city in cities'
          	:value='city.id'
          	>{{ city.state }} - {{ city.name }}
          </option>
				</select>
			</div>

			<div class="form-group col-4">
				<label class="m-0">INE:</label>
				<input
					type="file"
					class="form-control-file"
				>
			</div>
			<div class="form-group col-4">
				<label class="m-0">IMSS:</label>
				<input
					type="file"
					class="form-control-file"
				>
			</div>
			<div class="form-group col-4">
				<label class="m-0">Licencia:</label>
				<input
					type="file"
					class="form-control-file"
				>
			</div>

			<div class="form-group col-4">
				<input
					type="checkbox"
					class="form-check-control"
					v-model='operator.ine_check'
				>
				<label class="m-0">INE Vigente</label>
			</div>
			<div class="form-group col-4">
				<input
					type="checkbox"
					class="form-check-control"
					v-model='operator.license_check'
				>
				<label class="m-0">Licencia Vigente</label>
			</div>
			<div class="form-group col-4">
				<input
					type="checkbox"
					class="form-check-control"
					v-model='operator.imss_rfc_check'
				>
				<label class="m-0">IMSS coincide RFC de Linea</label>
			</div>
			<div class="form-group col-4">
				<input
					type="checkbox"
					class="form-check-control"
					v-model='operator.epp_check'
				>
				<label class="m-0">EPP</label>
			</div>

			<div class="col-12 text-right" v-if="!onRevision && !onReadOnly">
        <button
          v-show="onAudit"
          class="btn btn-primary text-center"
          @click="setStatusModal(status.review)"
          ><i class="fa fa-search"></i> Auditar
        </button>
				<button
					class="btn btn-success text-center"
					@click="wOperator"
					><i class="fa fa fa-floppy-o"></i> Guardar
				</button>
				<button
					class="btn btn-danger"
					@click="switchForm()"
					><i class="fa fa-times"></i> Cancelar
				</button>
			</div>
		</div>

    <!-- Modal -->
    <div class="modal fade" id="setStatusOperatorModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
            </button>
            <h5 class="modal-title">
              ¿Estas seguro que deseas
              {{onReadOnly ? 'deshabilitar' : 'enviar a auditaria'}}
              este operator?
            </h5>
          </div>
          <div class="modal-footer">
            <button
              class="btn"
              data-dismiss="modal"
              >Cancelar
            </button>
            <button
              v-if="onReadOnly"
              class="btn btn-secondary"
              data-dismiss="modal"
              @click="setStatus"
              >Deshabilitar
            </button>
            <button
              v-else
              class="btn btn-primary"
              data-dismiss="modal"
              @click="setStatus"
              >Auditar
            </button>
          </div>
        </div>
      </div>
    </div>

	</div>
</template>

<script>
	export default {
		name: 'OperatorComponent',
		data() {
		  return {
				idOperator: 0,
				showList: true,
				operators: {},
			  operator: {
				  city_id: '',
				  ine_check: false,
				  license_check: false,
				  imss_rfc_check: false,
				  epp_check: false,
				  ine: 'ine.pdf',
				  imss: 'imss.pdf',
				  license: 'license.pdf',
				  provider_id: '',
			  },
        status: {
          all: 0,
          review: 2,
          approve: 4,
          disabled: 5,
        },
        providers: {},
				cities: {},
        hasProvider: false,
				onAudit: false,
        OnRevision: false,
        onReadOnly: false,
		  }
		},
		mounted() {
			console.log(this.$options.name)
      this.onRevision = this.$route.params.onRevision
      this.onReadOnly = this.$route.params.onReadOnly
      if (this.$route.params.showOperator) {
        this.operator = this.$route.params.el
        this.switchForm(this.operator.id,false)
      }
      if (this.$route.params.el) {
        this.operator.provider_id = this.$route.params.el.id
        this.getOperators()
      } else {
        this.hasProvider = true
        this.getProviders()
        this.getAllOperators()
      }
		},
		methods: {
			switchForm(id=null,audit) {
				let provider = this.operator.provider_id
				this.onAudit = audit
        this.operator = this.$options.data().operator
        this.operator.provider_id = provider

        this.showList = !this.showList
        this.idOperator = id
        if (!this.showList) {
        	if (!this.cities.length) this.getCities()
        	if (!this.operator.provider_id) this.getAllOperators()
        	if (id) this.getOperator()
        }
      },
      getAllOperators() {
        this.axios
          .get(`${API_URL}provider/operator`)
          .then(resp => {
            this.operators = resp.data
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      getOperators() {
        let status
          = this.onReadOnly
          ? this.status.approve
          : this.status.all
        this.axios
          .get(`${API_URL}auditOperators/${status}/${this.operator.provider_id}`)
          .then(resp => {
            this.operators = resp.data
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
			getOperator() {
				this.axios
					.get(`${API_URL}provider/operator/${this.idOperator}`)
					.then(resp => {
						if (resp.data) {
							this.operator = resp.data
						}
					})
					.catch(err => console.log(err))
					.finally(() => this.loading = false)
			},
      wOperator() {
        if (this.$route.params.el) {
        	this.operator.provider_id = this.$route.params.el.id
        }
        if (this.idOperator) {
          this.editOperator()
        } else {
          this.addOperator()
        }
      },
			addOperator() {
				this.axios
					.post(API_URL + 'provider/operator', this.operator)
					.then(resp => {
            this.switchForm()
        		this.getOperators()
					})
					.catch(err => console.log(err))
					.finally(() => this.loading = false)
			},
      editOperator() {
        this.axios
          .patch(`${API_URL}provider/operator/${this.operator.id}`, this.operator)
          .then(resp => {
            this.switchForm()
        		this.getOperators()
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      deleteOperator(id) {
        this.axios
          .delete(`${API_URL}provider/operator/${id}`)
          .then(resp => {
            if (resp.data) {
              let i = this.operators.map(item => item.id).indexOf(id)
              this.operators.splice(i, 1)
            }
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      getProviders() {
        this.axios
          .get(API_URL + 'provider')
          .then(resp => {
            this.providers = resp.data
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      getCities() {
        this.axios
          .get(API_URL + 'cities')
          .then(resp => {
            this.cities = resp.data
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      setStatusModal(status,id=null) {
        this.operator.id = id ?? this.operator.id
        this.operator.status_id = this.operator.status = status
        $('#setStatusOperatorModal').modal('show')
      },
      setStatus() {
        this.axios
          .post(`${API_URL}setStatusOperator`, this.operator)
          .then(resp => {
            if (!this.showList) {
              this.switchForm()
            }
            if (!this.onReadOnly) {
              this.getAllOperators()
            }
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
		}
	}
</script>

<style scoped>
	.required:before {
  	content:"*";
  	color:red;
	}
</style>