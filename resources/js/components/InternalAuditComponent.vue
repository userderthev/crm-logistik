<template>
  <div class="container">

    <h3 class="text-center">Modulo de Auditoría</h3>

    <!-- <div class="form-group row col my-3">
      <select class="form-control" v-model='traffic.rejection_motive_id'>
        <option value selected disabled>Seleccionar motivo:</option>
        <option
          v-for="rejectionMotive in rejectionMotives"
          :value="rejectionMotive.id"
          >{{rejectionMotive.description}}
        </option>
      </select>
    </div> -->

    <div class="row justify-content-md-end">
      <div class="col-4">
      <div class="form-group row">
        <label class="col col-form-label text-right px-0">Filtrar por Status:</label>
        <div class="col">
          <select class="form-control">
            <option value="" selected>Todos los Status</option>
            <option>Pendiente</option>
            <option>Revision</option>
            <option>Rechazado</option>
            <option>Aprobado</option>
            <option>Inhabilitado</option>
          </select>
        </div>
      </div>

      </div>
    </div>
    <div>
      <vue-good-table
        styleClass="vgt-table striped condensed"
        :columns="columns"
        :rows="rows"
        :fixed-header="true"
        :group-options="{
          enabled: true,
          collapsable: false,
        }"
      >
        <template slot="table-row" slot-scope="props">
          <span v-if="props.column.label =='Opciones'">
            <i
              role="button"
              class="fa fa-search text-muted"
              data-toggle="tooltip"
              data-placement="top"
              title="Auditar"
              @click="checkOut(props.row)"
            ></i>
            <i
              role="button"
              class="fa fa-check text-success"
              data-toggle="tooltip"
              data-placement="top"
              title="Aprobar"
              @click="changeStatusModal(props.row,true)"
            ></i>
            <i
              role="button"
              class="fa fa-times text-danger"
              data-toggle="tooltip"
              data-placement="top"
              title="Rechazar"
              @click="changeStatusModal(props.row,false)"
            ></i>
          </span>
          <span v-else-if="props.column.label =='Status' && props.row.status_id == 1">
            <span class="badge badge-primary">Pendiente</span>
          </span>
          <span v-else-if="props.column.label =='Status' && props.row.status_id == 2">
            <span class="badge badge-warning">Revision</span>
          </span>
          <span v-else-if="props.column.label =='Status' && props.row.status_id == 3">
            <span class="badge badge-danger">Rechazado</span>
          </span>
          <span v-else-if="props.column.label =='Status' && props.row.status_id == 4">
            <span class="badge badge-success">Aprovado</span>
          </span>
          <span v-else-if="props.column.label =='Status' && props.row.status_id == 5">
            <span class="badge badge-muted">Inhabilitado</span>
          </span>
          <span v-else>
            {{ props.formattedRow[props.column.field] }}
          </span>
        </template>
      </vue-good-table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="auditModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
            </button>
            <h5 class="modal-title">
              {{ module }}: ¿Estas seguro que deseas {{ modalMode ? 'aprobar' : 'rechazar'}}?
            </h5>
          </div>
          <div class="modal-footer">
            <button
              class="btn"
              data-dismiss="modal"
              >Cancelar
            </button>
            <button
              v-if="modalMode"
              class="btn btn-success"
              @click="setStatus"
              >Aprobar
            </button>
            <button
              v-else
              class="btn btn-danger"
              @click="setStatus"
              >Rechazar
            </button>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>

  export default {
    name: 'InternalAuditComponent',
    data() {
      return {
        status: {
          pending: 1,
          review: 2,
          reject: 3,
          approve: 4,
        },
        obj: {},
        routeParams: {},
        lines: [],
        trucks: [],
        towings: [],
        operators: [],
        columns: [
          {
            label: 'Nombre',
            field: 'name',
          },
          {
            label: 'Telefono',
            field: 'phone',
            type: 'string',
          },
          {
            label: 'RFC',
            field: 'rfc',
            type: 'string',
          },
          {
            label: 'Tipo',
            field: 'type',
            type: 'string',
          },
          {
            label: 'Placas',
            field: 'plates',
            type: 'string',
          },
          {
            label: 'Status',
            field: 'status',
            type: 'string',
            tdClass: 'text-center',
          },
          {
            label: 'Creacion',
            field: 'created_at',
            type: 'date',
            dateInputFormat: 'yyyy-MM-dd HH:mm:ss',
            dateOutputFormat: 'dd/MM/yyyy',
          },
          {
            label: 'Opciones',
            field: 'options',
            tdClass: 'text-center',
          },
        ],
        rows: [
          {
            mode: 'span', // span means this header will span all columns
            label: 'Lineas', // this is the label that'll be used for the header
            children: [],
          },
          {
            mode: 'span',
            label: 'Unidades',
            children: [],
          },
          {
            mode: 'span',
            label: 'Remolques',
            children: [],
          },
          {
            mode: 'span',
            label: 'Operadores', // this is the label that'll be used for the header
            children: [],
          },
        ],
        URI: '',
        module: '',
        modalMode: false,
      }
    },
    mounted() {
      console.log(this.$options.name)
      this.getLines()
      this.getTrucks()
      this.getTowings()
      this.getOperators()
    },
    methods: {
      checkOut(props) {
        this.routeParams = {
          el: props,
          onRevision: true,
        }
        this.getTagModule(props)
        this.$router.push({
          name: 'editProvider',
          params: this.routeParams,
        })
      },
      changeStatusModal(props,mode) {
        this.modalMode = mode
        this.obj = props
        this.getTagModule(props)
        $('#auditModal').modal('show')
      },
      getTagModule(module) {
        switch ( module.vgt_id ) {
          case 0:
            this.module = 'Linea'
            this.URI = 'Line'
            this.routeParams.showReference = true
            this.routeParams.tab = '#line-tab'
            break
          case 1:
            this.module = 'Unidad'
            this.URI = 'Truck'
            this.routeParams.showTruck = true
            this.routeParams.tab = '#truck-tab'
            break
          case 2:
            this.module = 'Remolque'
            this.URI = 'Towing'
            this.routeParams.showTowing = true
            this.routeParams.tab = '#towing-tab'
            break
          case 3:
            this.module = 'Operador'
            this.URI = 'Operator'
            this.routeParams.showOperator = true
            this.routeParams.tab = '#operator-tab'
            break
          default:
        }
      },
      getLines() {
        this.axios
          .get(API_URL + 'auditProviders/' + this.status.review)
          .then(resp => {
            this.lines = resp.data
            this.rows[0].children = this.lines
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      getTrucks() {
        this.axios
          .get(API_URL + 'auditTrucks/' + this.status.review)
          .then(resp => {
            this.trucks = resp.data
            this.rows[1].children = this.trucks
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      getTowings() {
        this.axios
          .get(API_URL + 'auditTowings/' + this.status.review)
          .then(resp => {
            this.towings = resp.data
            this.rows[2].children = this.towings
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      getOperators() {
        this.axios
          .get(API_URL + 'auditOperators/' + this.status.review)
          .then(resp => {
            this.operators = resp.data
            this.rows[3].children = this.operators
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      setStatus() {
        this.obj.status = this.modalMode ? this.status.approve : this.status.reject
        this.obj.status_id = this.obj.status
        this.axios
          .post(`${API_URL}setStatus${this.URI}`, this.obj)
          .then(resp => {
            this.obj = {}
            // this[`get${this.URI}s`]();
            $('#auditModal').modal('hide')
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
    }
  }
</script>

<style scoped>

</style>
