<template>
	<div class="container">

    <div v-if="showList">

			<div class="row my-3">
      	<div class="col-7 align-self-center">
        	<h4>Lista de Remolques</h4>
      	</div>

      	<div v-if="noProvider" class="col-6 align-self-center">
        	<select
          	class="form-control"
          	v-model='towing.provider_id'
          	@change="getTowings"
        	>
          	<option value="" selected disabled>Elegir un Proveedor</option>
          	<option v-for="provider in providers" :value="provider.id">{{provider.name}}</option>
        	</select>
      	</div>

      	<div class="col text-right">
        	<button
            v-show="!onReadOnly"
          	@click="switchForm()"
          	class="btn btn-primary"
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
            <th>Tipo de Remolque</th>
            <th>Placas</th>
            <th>Rieles Logisticos</th>
            <th>Gatas</th>
            <th>Sin Filtracion</th>
            <th>Status</th>
            <th class="text-center">Opciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="towing in towings" :key="towing.id">
            <td class="py-0">{{ towing.type }}</td>
            <td class="py-0">{{ towing.plates }}</td>
            <td class="py-0">{{ towing.rails }}</td>
            <td class="py-0">{{ towing.jacks }}</td>
            <td class="py-0">{{ towing.without_filtration }}</td>
            <td class="py-1 text-center text-md">
              <span v-if="towing.status_id == 1" class="badge badge-primary">Pendiente</span>
              <span v-else-if="towing.status_id == 2" class="badge badge-warning">Revision</span>
              <span v-else-if="towing.status_id == 3" class="badge badge-danger">Rechazado</span>
              <span v-else-if="towing.status_id == 4" class="badge badge-success">Aprovado</span>
              <span v-else class="badge badge-muted">Inhabilitado</span>
            </td>
            <td class="py-0 text-center">
              <div class="btn-group" role="group" v-if="!onRevision && !onReadOnly">
                <button
                  class="btn btn-light text-primary"
                  @click="switchForm(towing.id,true)"
                  ><i class="fa fa-search"></i>
                </button>
                <button
                  class="btn btn-light text-muted"
                  @click="switchForm(towing.id,false)"
                  ><i class="fa fa-edit"></i>
                </button>
                <button
                  class="btn btn-light text-danger"
                  @click="deleteTowing(towing.id,false)"
                  ><i class="fa fa-trash"></i>
                </button>
              </div>
              <div class="btn-group" role="group" v-else>
                <button
                  class="btn btn-light text-muted"
                  @click="switchForm(towing.id,false)"
                  ><i class="fa fa-eye"></i>
                </button>
                <button
                  class="btn btn-light text-muted"
                  @click="setStatusModal(status.disabled)"
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
				<label class="required m-0">Tipo de Remolque:</label>
				<select
					required
					class="form-control"
					v-model='towing.type'
				>
					<option value="" selected disabled>Elegir tipo de remolque</option>
					<option>Caja seca 48"</option>
					<option>Caja seca 53"</option>
					<option>Termo 48"</option>
					<option>Termo 53"</option>
					<option>Caja seca</option>
					<option>Jaula</option>
					<option>Plana 40"</option>
					<option>Plana 53"</option>
					<option>Full</option>
					<option>Lowboy</option>
				</select>
			</div>

			<!-- // Activar casilla para la segunda plana al seleccionar opcion full-->

			<div class="form-group col-6">
				<label class="required m-0">Placas:</label>
				<input
					required
					class="form-control"
					placeholder="Ingresar placas"
					v-model='towing.plates'
				>
			</div>

			<div class="form-group col-4">
					<input
						type="checkbox"
						class="form-check-control"
						v-model='towing.rails'
					>
					<label class="m-0">Rieles Logisticos</label>
			</div>
			<div class="form-group col-4">
					<input
						type="checkbox"
						class="form-check-control"
						v-model='towing.jacks'
					>
					<label class="m-0">Gatas:</label>
			</div>
			<div class="form-group col-4">
					<input
						type="checkbox"
						class="form-check-control"
						placeholder="Ingresar RFC"
						v-model='towing.oversize_permit'
					>
					<label class="m-0">Permiso Sobredimension</label>
			</div>
			<div class="form-group col-4">
					<input
						type="checkbox"
						class="form-check-control"
						placeholder="Ingresar nombre coordinador"
						v-model='towing.without_filtration'
					>
					<label class="m-0">Sin Filtracion</label>
			</div>
			<div class="form-group col-4">
					<input
						type="checkbox"
						class="form-check-control"
						placeholder="Ingresar ine propietario"
						v-model='towing.no_odor'
					>
					<label class="m-0">Sin Olores</label>
			</div>
			<div class="form-group col-4">
					<input
						type="checkbox"
						class="form-check-control"
						placeholder="Ingresar rfc propietario"
						v-model='towing.no_water_filtration'
					>
					<label class="m-0">Sin Filtracion Agua</label>
			</div>

			<div class="form-group col-4">
				<label class="m-0">Tarjeta Circulacion de Remolque:</label>
				<input
					type="file"
					class="form-control-file"
				>
			</div>
			<div class="form-group col-4">
				<label class="m-0">Poliza de seguro:</label>
				<input
					type="file"
					class="form-control-file"
				>
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
					@click="wTowing"
					><i class="fa fa-floppy-o"></i> Guardar
				</button>
				<button
					class="btn btn-danger"
					@click="switchForm()"
					><i class="fa fa-times"></i> Cancelar
				</button>
			</div>
		</div>

    <!-- Modal -->
    <div class="modal fade" id="setStatusTowingModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
            </button>
            <h5 class="modal-title">
              ¿Estas seguro que deseas
              {{onReadOnly ? 'deshabilitar' : 'enviar a auditaria'}}
              este remolque?
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
		name: 'TowingComponent',
		data() {
			return {
				idTowing: 0,
				showList: true,
				towings: {},
				towing: {
					type: '',
					rails: false,
					jacks: false,
					oversize_permit: false,
					without_filtration: false,
					no_odor: false,
					no_water_filtration: false,
					traffic_card: 'traffic_card.pdf',
					provider_id: '',
				},
        status: {
          all: 0,
          review: 2,
          approve: 4,
          disabled: 5,
        },
        providers: {},
        noProvider: false,
        onAudit: false,
        OnRevision: false,
        onReadOnly: false,
			}
		},
		mounted() {
			console.log(this.$options.name)
      this.onRevision = this.$route.params.onRevision
      this.onReadOnly = this.$route.params.onReadOnly
      if (this.$route.params.showTowing) {
        this.towing = this.$route.params.el
        this.switchForm(this.towing.id,false)
      }
      if (this.$route.params.el) {
        this.towing.provider_id = this.$route.params.el.id
        this.getTowings()
      } else {
        this.noProvider = true;
        this.getProviders()
        this.getAllTowings()
      }
		},
		methods: {
			switchForm(id=null,audit) {
        let provider = this.towing.provider_id
        this.onAudit = audit
        this.towing = this.$options.data().towing
        this.towing.provider_id = provider
        this.showList = !this.showList
        this.idTowing = id
        if (!this.showList) {
          if (!this.towing.provider_id) this.getAllTowings()
        	if (id) this.getTowing()
        }
      },
      getAllTowings() {
        this.axios
          .get(`${API_URL}provider/towing`)
          .then(resp => {
            this.towings = resp.data
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      getTowings() {
        let status
          = this.onReadOnly
          ? this.status.approve
          : this.status.all
        this.axios
          .get(`${API_URL}auditTowings/${status}/${this.towing.provider_id}`)
          .then(resp => {
            this.towings = resp.data
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
			getTowing() {
				this.axios
					.get(`${API_URL}provider/towing/${this.idTowing}`)
					.then(resp => {
						if (resp.data) {
							this.towing = resp.data
						}
					})
					.catch(err => console.log(err))
					.finally(() => this.loading = false)
			},
      wTowing() {
        if (this.$route.params.el) {
          this.towing.provider_id = this.$route.params.el.id
        }
        if (this.idTowing) {
          this.editTowing()
        } else {
          this.addTowing()
        }
      },
			addTowing() {
				this.axios
					.post(API_URL + 'provider/towing', this.towing)
					.then(resp => {
						this.switchForm()
        		this.getTowings()
					})
					.catch(err => console.log(err))
					.finally(() => this.loading = false)
			},
      editTowing() {
        this.axios
          .patch(`${API_URL}provider/towing/${this.towing.id}`, this.towing)
          .then(resp => {
            this.switchForm()
            this.getTowings()
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      deleteTowing(id) {
        this.axios
          .delete(`${API_URL}provider/towing/${id}`)
          .then(resp => {
            if (resp.data) {
              let i = this.towings.map(item => item.id).indexOf(id);
              this.towings.splice(i, 1)
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
      setStatusModal(status) {
        this.towing.status = status
        $('#setStatusTowingModal').modal('show')
      },
      setStatus() {
        this.axios
          .post(`${API_URL}setStatusTowing`, this.towing)
          .then(resp => {
            if (!this.showList) {
              this.switchForm()
            }
            this.getAllTowings()
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
		},
	}
</script>

<style scoped>
	.required:before {
		content:"*";
		color:red;
	}
</style>