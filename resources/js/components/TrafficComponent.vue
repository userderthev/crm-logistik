<template>
  <div class="container">

    <h3 class="text-center m-0 p-0">Modulo de Unidades Disponibles</h3>

    <div v-if="showList">
      <div class="col text-right p-0 mb-2">
        <button
          @click="switchForm()"
          class="btn btn-primary"
          ><i class="fa fa-plus-circle"></i> Agregar
        </button>
      </div>

      <table class="table table-hover">
        <thead class="thead-light">
          <tr>
            <th class="text-center">Id</th>
            <th>Linea</th>
            <th>Tipo de Unidad</th>
            <th>Operador</th>
            <th>Ciudad Origen</th>
            <th>Ciudad Destino</th>
            <th class="text-center">Tiempo Restante</th>
            <th class="text-center">Opciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="traffic in traffics" :key="traffic.id">
            <td class="py-1">{{ traffic.slug }}</td>
            <td class="py-1">{{ traffic.provider.name }}</td>
            <td class="py-1">{{ traffic.truck.type }}</td>
            <td class="py-1">{{ traffic.operator.name }}</td>
            <td class="py-1">{{ traffic.origin.name }}</td>
            <td class="py-1">{{ traffic.target.name }}</td>
            <td class="py-0 text-bold text-center">
              <flip-countdown
                :showDays='false'
                :deadline='timer(traffic)'
                @timeElapsed="timer(traffic)"
              ></flip-countdown>
            </td>
            <td class="py-0 text-center">
              <div class="btn-group" role="group">
                <div class="py-1">
                  <i
                    class="fa fa-edit text-muted handle"
                    @click="switchForm(traffic.id)"
                  ></i>
                  <i
                    class="fa fa-trash text-danger handle"
                    @click="showCauseRejectModal(traffic.id)"
                  ></i>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <table class="table table-hover">
        <thead class="thead-light">
          <tr>
            <th class="text-center">Id</th>
            <th>Linea</th>
            <th>Tipo de Unidad</th>
            <th>Operador</th>
            <th>Ciudad Origen</th>
            <th>Ciudad Destino</th>
            <th class="text-center">Opciones</th>
            <th class="text-center">Opciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="traffic in disabledTraffics">
            <td class="py-1">{{ traffic.slug }}</td>
            <td class="py-1">{{ traffic.provider.name }}</td>
            <td class="py-1">{{ traffic.truck.type }}</td>
            <td class="py-1">{{ traffic.operator.name }}</td>
            <td class="py-1">{{ traffic.origin.name }}</td>
            <td class="py-1">{{ traffic.target.name }}</td>
            <td class="py-0 text-center">
              <button
                class="btn btn-link"
                @click="active(traffic)"
                >Reactivar Unidad
              </button>
            </td>
            <td class="py-0 text-center">
              <div class="btn-group" role="group">
                <div class="py-1 handle">
                  <i
                    class="fa fa-edit text-muted handle"
                    @click="switchForm(traffic.id)"
                  ></i>
                  <i
                    class="fa fa-trash text-danger handle"
                    @click="showCauseRejectModal(traffic.id)"
                  ></i>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Modal -->
      <div class="modal fade" id="causeRejectModal" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">

              <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
              </button>

              <h5 class="modal-title">
                ¿Especifique motivo para eliminar unidad disponible?
              </h5>

              <div class="form-group row col my-3">
                <select class="form-control" v-model='traffic.rejection_motive_id'>
                  <option value selected disabled>Seleccionar motivo:</option>
                  <option
                    v-for="rejectionMotive in rejectionMotives"
                    :value="rejectionMotive.id"
                    >{{rejectionMotive.description}}
                  </option>
                </select>
              </div>

            </div>
            <div class="modal-footer">
              <button
                class="btn btn-secondary"
                data-dismiss="modal"
                >Cancelar
              </button>
              <button
                type="button"
                class="btn btn-danger"
                @click="handleDeleteWithMotive()"
                >Eliminar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row pt-3" v-else>
      <div class="form-group col-4">
        <label class="m-0">Linea:</label>
        <select
          class="form-control"
          v-model='traffic.line_id'
          @change='setTrafficFields'
        >
          <option value selected disabled>Elegir una linea</option>
          <option v-for='line in lines' :value='line.id'>{{ line.name }}</option>
        </select>
      </div>

      <div class="form-group col-4">
        <label class="m-0">Unidad:</label>
        <select
          class="form-control"
          v-model='traffic.truck_id'
        >
          <option value selected disabled>Elegir una unidad</option>
          <option v-for='truck in trucks' :value='truck.id'>{{ truck.type }}</option>
        </select>
      </div>

      <div class="form-group col-4">
        <label class="m-0">Operador:</label>
        <select
          class="form-control"
          v-model='traffic.operator_id'
        >
          <option value selected disabled>Elegir un operador</option>
          <option v-for='operator in operators' :value='operator.id'>{{ operator.name }}</option>
        </select>
      </div>

      <div class="form-group col-6">
        <label class="m-0">Ciudad Origen:</label>
        <select
          class="form-control"
          v-model='traffic.origin_city'
        >
          <option value selected disabled>Elegir ciudad origen</option>
          <option v-for='city in cities' :value='city.id'>{{ city.state }} - {{ city.name }}</option>
        </select>
      </div>

      <div class="form-group col-6">
        <label class="m-0">Ciudad Destino:</label>
        <select
          class="form-control"
          v-model='traffic.target_city'
        >
          <option value selected disabled>Elegir ciudad destino</option>
          <option v-for='city in cities' :value='city.id'>{{ city.state }} - {{ city.name }}</option>
        </select>
      </div>

      <div class="col-12 text-right">
        <button
          @click="wTraffic"
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
  import FlipCountdown from 'vue2-flip-countdown'

  export default {
    name: 'TrafficComponent',
    components: { FlipCountdown },
    data() {
      return {
        showList: true,
        traffics: {},
        disabledTraffics: [],
        traffic: {
          line_id: '',
          truck_id: '',
          operator_id: '',
          origin_city: '',
          target_city: '',
          rejection_motive_id: '',
        },
        status: {
          approve: 4,
        },
        lines: {},
        trucks: {},
        operators: {},
        cities: {},
        rejectionMotives: [],
        timerCount: 10800,
      }
    },
    mounted() {
      console.log(this.$options.name)
      this.getTraffics()
    },
    methods: {
      timer(traffic) {
        // let init = traffic.created_at
        // let deadline = moment(init).add(3,'hour').format('YYYY-MM-DD H:mm:ss')
        let deadline = traffic.deadline
        if (moment().isAfter(deadline)) {
          this.disabledTraffics.unshift(traffic)
          this.traffics = this.traffics.filter(item => item != traffic)
          this.destroyUnitAvailable(traffic.available_units.id)
        }
        return deadline
      },
      active(traffic) {
        this.axios
          .post(API_URL + 'provider/available_units',traffic)
          .then(resp => {
            traffic.deadline = resp.data.deadline
            this.traffics.unshift(traffic)
            this.disabledTraffics = this.disabledTraffics.filter(item => item != traffic)
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      switchForm(id=null) {
        console.log('switchForm()',id)
        this.showList     = !this.showList
        this.traffic      = this.$options.data().traffic
        this.traffic.id   = id
        if (!this.lines.length || !this.cities.length) this.getCatalogs()
        if (id) this.getTraffic()
      },
      setTrafficFields() {
        this.traffic.truck_id = ''
        this.traffic.operator_id = ''
        this.getTrafficCatalogs()
      },
      getTraffics() {
        this.axios
          .get(API_URL + 'provider/traffic')
          .then(resp => {
            if (resp.data) {
              this.traffics = resp.data.enabledTraffics
              this.disabledTraffics = resp.data.disabledTraffics
            }
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      getTraffic() {
        this.axios
          .get(`${API_URL}provider/traffic/${this.traffic.id}`)
          .then(resp => {
            if (resp.data) {
              this.traffic = resp.data
              this.getTrafficCatalogs()
            }
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      getLines() {
        this.axios
          .get(API_URL + 'auditProviders/' + this.status.approve)
          .then(resp => {
            this.lines = resp.data
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      getTrucks() {
        this.axios
          .get(`${API_URL}auditTrucks/${this.status.approve}/${this.traffic.line_id}`)
          .then(resp => {
            this.trucks = resp.data
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      getOperators() {
        this.axios
          .get(`${API_URL}auditOperators/${this.status.approve}/${this.traffic.line_id}`)
          .then(resp => {
            this.operators = resp.data
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
      getCatalogs() {
        this.getLines()
        this.getCities()
      },
      getTrafficCatalogs() {
        this.getTrucks()
        this.getOperators()
      },
      getRejectionMotives() {
        this.axios
          .get(API_URL + 'rejectionMotives')
          .then(resp => {
            if (resp.data) {
              this.rejectionMotives = resp.data
            }
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      wTraffic() {
        console.log('wTraffic()',this.traffic.id)
        this.traffic.provider_id = this.traffic.line_id
        if (this.traffic.id) {
          this.editTraffic()
        } else {
          this.addTraffic()
        }
        this.disabledTraffics = []
        this.getTraffics()
      },
      addTraffic() {
        this.axios
          .post(API_URL + 'provider/traffic', this.traffic)
          .then(resp => {
            this.switchForm()
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      editTraffic() {
        this.axios
          .patch(`${API_URL}provider/traffic/${this.traffic.id}`, this.traffic)
          .then(resp => {
            if (!this.traffic.rejection_motive_id) {
              this.switchForm()
            }
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      handleDeleteWithMotive() {
        if (this.traffic.rejection_motive_id) {
          this.editTraffic()
          this.deleteTraffic()
          $('#causeRejectModal').modal('hide')
        }
      },
      deleteTraffic() {
        let id = this.traffic.id
        this.axios
          .delete(`${API_URL}provider/traffic/${id}`)
          .then(resp => {
            if (resp.data) {
              this.traffics = this.traffics.filter(item => item.id != id)
              this.disabledTraffics = this.disabledTraffics.filter(item => item.id != id)
              this.traffic.id = ''
            }
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      destroyUnitAvailable(id) {
        this.axios
          .delete(`${API_URL}provider/available_units/${id}`)
          .then(resp => {})
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      showCauseRejectModal(id) {
        this.traffic.id = id
        this.traffic.rejection_motive_id = ''
        if (!this.rejectionMotives.length) {
          this.getRejectionMotives()
        }
        $('#causeRejectModal').modal('show')
      },
    },
    watch: {
      timerCount: {
        handler(value) {
          if (value > 0) {
            setTimeout(() => {
              this.timerCount--;
            }, 1000);
          }
        },
        immediate: true // This ensures the watcher is triggered upon creation
      }
    }
  }
</script>

<style scoped>
  .handle {
    cursor: pointer;
  }
</style>
