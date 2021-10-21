<template>
  <div class="container">

    <div v-if="showList">

      <div class="row my-3">
        <div class="col-7 align-self-center">
          <h4>Lista de Unidades</h4>
        </div>

        <div v-if="hasProvider" class="col-6 align-self-center">
          <select
            class="form-control"
            v-model='truck.provider_id'
            @change="getTrucks"
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
            <th>Tipo de Unidad</th>
            <th>Placas</th>
            <th>Marca</th>
            <th class="text-center">Año</th>
            <th>Color</th>
            <th>Status</th>
            <th class="text-center">Opciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="truck in trucks" :key="truck.id">
            <td class="py-0">{{ truck.type }}</td>
            <td class="py-0">{{ truck.placas }}</td>
            <td class="py-0">{{ truck.brand }}</td>
            <td class="py-0 text-center">{{ truck.year }}</td>
            <td class="py-0">{{ truck.color }}</td>
            <td class="py-1 text-center text-md">
              <span v-if="truck.status_id == 1" class="badge badge-primary">Pendiente</span>
              <span v-else-if="truck.status_id == 2" class="badge badge-warning">Revision</span>
              <span v-else-if="truck.status_id == 3" class="badge badge-danger">Rechazado</span>
              <span v-else-if="truck.status_id == 4" class="badge badge-success">Aprovado</span>
              <span v-else class="badge badge-secondary">Inhabilitado</span>
            </td>
            <td class="py-0 text-center">

              <div class="btn-group" role="group" v-if="!onRevision && !onReadOnly">
                <button
                  class="btn btn-light text-primary"
                  @click="switchForm(truck.id,true)"
                  ><i class="fa fa-search"></i>
                </button>
                <button
                  class="btn btn-light text-muted"
                  @click="switchForm(truck.id,false)"
                  ><i class="fa fa-edit"></i>
                </button>
                <button
                  class="btn btn-light text-danger"
                  @click="deleteTruck(truck.id,false)"
                  ><i class="fa fa-trash"></i>
                </button>
              </div>

              <div class="btn-group" role="group" v-else>
                <button
                  class="btn btn-light text-muted"
                  @click="switchForm(truck.id,false)"
                  ><i class="fa fa-eye"></i>
                </button>
                <button
                  class="btn btn-light text-muted"
                  @click="setStatusModal(truck.id,status.disabled)"
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
        <label class="required m-0">Tipo de Unidad:</label>
        <select
          required
          class="form-control"
          v-model='truck.type'
        >
          <option value="" selected disabled>Elegir tipo de unidad</option>
          <option>Trailer</option>
          <option>Torton</option>
          <option>Mudancero</option>
          <option>Rabon</option>
          <option>5.5 Tons</option>
          <option>3.5 Tons</option>
          <option>1.5 Tons</option>
        </select>
      </div>
      <div class="form-group col-3">
        <label class="required m-0">Placas:</label>
        <input
          required
          class="form-control"
          placeholder="Ingresar placas"
          v-model='truck.placas'
        >
      </div>
      <div class="form-group col-3">
        <label class="m-0">Año:</label>
        <input
          class="form-control"
          placeholder="Ingresar año"
          v-model='truck.year'
        >
      </div>
      <div class="form-group col-4">
        <label class="m-0">Marca:</label>
        <input
          class="form-control"
          placeholder="Ingresar marca"
          v-model='truck.brand'
        >
      </div>
      <div class="form-group col-4">
        <label class="m-0">Color:</label>
        <input
          class="form-control"
          placeholder="Ingresar color"
          v-model='truck.color'
        >
      </div>
      <div class="form-group col-4">
        <label class="m-0">GPS Link:</label>
        <input
          class="form-control"
          placeholder="Ingresar link gps"
          v-model='truck.gps_link'
        >
      </div>
      <div class="form-group col-6">
        <label class="m-0">GPS Usuario:</label>
        <input
          class="form-control"
          placeholder="Ingresar usuario gps"
          v-model='truck.gps_user'
        >
      </div>
      <div class="form-group col-6">
        <label class="m-0">GPS Password:</label>
        <input
          type="password"
          class="form-control"
          placeholder="Ingresar password gps"
          v-model='truck.gps_password'
        >
      </div>
      <div class="form-group col-4">
        <input
          type="checkbox"
          class="form-check-control"
          v-model='truck.extinguidor'
        ></input>
        <label class="m-0">Extinguidor</label>
      </div>
      <div class="form-group col-4">
        <input
          type="checkbox"
          class="form-check-control"
          v-model='truck.alarma_reversa'
        ></input>
        <label class="m-0">Alarma Reversa</label>
      </div>
      <div class="form-group col-4">
        <input
          type="checkbox"
          class="form-check-control"
          v-model='truck.fumigacion'
        ></input>
        <label class="m-0">Certificacion Fumigacion</label>
      </div>
      <div class="form-group col-4">
        <input
          type="checkbox"
          class="form-check-control"
          v-model='truck.driver_card_check'
        ></input>
        <label class="m-0">Tarjeta Circulacion</label>
      </div>
      <div class="form-group col-4">
        <input
          type="checkbox"
          class="form-check-control"
          v-model='truck.secure_check'
        ></input>
        <label class="m-0">Seguro</label>
      </div>
      <div class="form-group col-4 align-self-end">
        <input
          type="checkbox"
          class="form-check-control"
          v-model='truck.calzas'
        ></input>
        <label class="m-0">Calzas</label>
      </div>
      <div class="form-group col-4">
        <label class="m-0">Tarjeta de Circulacion</label>
        <input
          type="file"
          class="form-control-file"
        >
      </div>
      <div class="form-group col-8">
        <label class="m-0">Seguro:</label>
        <input
          type="file"
          class="form-control-file"
        >
      </div>

      <!--
        <div class="col-6">
          <div class="row">
            <div class="form-group col-auto align-self-end">
              <input
              type="checkbox"
              class="form-check-control"
              v-model='truck.driver_card_check'
              ></input>
              <label class="m-0">Tarjeta Circulacion</label>
            </div>
            <div class="form-group col-auto">
              <label class="m-0">Tarjeta de Circulacion:</label>
              <input
              type="file"
              class="form-control-file"
              >
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="row">
            <div class="form-group col-auto align-self-end">
              <input
              type="checkbox"
              class="form-check-control"
              v-model='truck.secure_check'
              ></input>
              <label class="m-0">Seguro</label>
            </div>
            <div class="form-group col-auto">
              <label class="m-0">Seguro:</label>
              <input
              type="file"
              class="form-control-file"
              >
            </div>
          </div>
        </div>
      -->

      <div class="col-12 text-right" v-if="!onRevision && !onReadOnly">
        <button
          v-show="onAudit"
          @click="setStatusModal(truck.id,status.review)"
          class="btn btn-primary text-center"
          ><i class="fa fa-search"></i> Auditar
        </button>
        <button
          @click="wTruck"
          class="btn btn-success text-center"
          ><i class="fa fa-floppy-o"></i> Guardar
        </button>
        <button
          @click="switchForm()"
          class="btn btn-danger"
          ><i class="fa fa-times"></i> Cancelar
        </button>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="setStatusTruckModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
            </button>
            <h5 class="modal-title">
              ¿Estas seguro que deseas
              {{onReadOnly ? 'deshabilitar' : 'enviar a auditaria'}}
              esta unidad?
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
    name: 'TruckComponent',
    data() {
      return {
        idTruck: 0,
        showList: true,
        trucks: {},
        truck: {
          type: '',
          calzas: false,
          extinguidor: false,
          alarma_reversa: false,
          fumigacion: false,
          driver_card_check: false,
          secure_check: false,
          driver_card: 'driver_card.pdf',
          secure: 'secure.pdf',
          provider_id: '',
        },
        status: {
          all: 0,
          review: 2,
          approve: 4,
          disabled: 5,
        },
        providers: {},
        hasProvider: false,
        onAudit: false,
        onRevision: false,
        onReadOnly: false,
      }
    },
    mounted() {
      console.log(this.$options.name)
      this.onRevision = this.$route.params.onRevision
      this.onReadOnly = this.$route.params.onReadOnly
      if (this.$route.params.showTruck) {
        this.truck = this.$route.params.el
        this.switchForm(this.truck.id,false)
      }
      if (this.$route.params.el) {
        this.truck.provider_id = this.$route.params.el.id
        this.getTrucks()
      } else {
        this.hasProvider = true;
        this.getProviders()
        this.getAllTrucks()
      }
    },
    methods: {
      switchForm(id=null,audit) {
        let provider = this.truck.provider_id
        this.onAudit = audit
        this.truck = this.$options.data().truck
        this.truck.provider_id = provider

        this.showList = !this.showList
        this.idTruck = id
        if (!this.showList) {
          if (!this.truck.provider_id) this.getAllTrucks()
          if (id) this.getTruck()
        }
      },
      getAllTrucks() {
        this.axios
          .get(`${API_URL}provider/truck`)
          .then(resp => {
            this.trucks = resp.data
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      getTrucks() {
        let status
          = this.onReadOnly
          ? this.status.approve
          : this.status.all
        this.axios
          .get(`${API_URL}auditTrucks/${status}/${this.truck.provider_id}`)
          .then(resp => {
            this.trucks = resp.data
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      getTruck() {
        this.axios
          .get(`${API_URL}provider/truck/${this.idTruck}`)
          .then(resp => {
            if (resp.data) {
              this.truck = resp.data
            }
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      wTruck() {
        if (this.$route.params.el) {
          this.truck.provider_id = this.$route.params.el.id
        }
        if (this.idTruck) {
          this.editTruck()
        } else {
          this.addTruck()
        }
      },
      addTruck() {
        this.axios
          .post(API_URL + 'provider/truck', this.truck)
          .then(resp => {
            this.switchForm()
            this.getTrucks()
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      editTruck() {
        this.axios
          .patch(`${API_URL}provider/truck/${this.truck.id}`, this.truck)
          .then(resp => {
            this.switchForm()
            this.getTrucks()
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      deleteTruck(id) {
        this.axios
          .delete(`${API_URL}provider/truck/${id}`)
          .then(resp => {
            if (resp.data) {
              let i = this.trucks.map(item => item.id).indexOf(id);
              this.trucks.splice(i, 1)
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
      setStatusModal(id,status) {
        this.truck = {
          id: id,
          status: status,
          status_id: status,
        }
        $('#setStatusTruckModal').modal('show')
      },
      setStatus() {
        this.axios
          .post(`${API_URL}setStatusTruck`, this.truck)
          .then(resp => {
            if (!this.showList) {
              this.switchForm()
            }
            if (!this.onReadOnly) {
              this.getAllTrucks()
            }
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