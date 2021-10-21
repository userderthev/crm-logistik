<template>
  <div class="container">
    <h3 class="text-center col">Editar Proveedores</h3>
    <div class="col-12">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a
            class="nav-link active"
            id="line-tab"
            data-toggle="tab"
            href="#line"
            role="tab"
            >Lineas
          </a>
        </li>
        <li class="nav-item">
          <a
            v-if="!showAudit || showReference"
            class="nav-link"
            id="reference-tab"
            data-toggle="tab"
            href="#reference"
            role="tab"
            >Referencias
          </a>
        </li>
        <li v-if="!showAudit || showTruck" class="nav-item">
          <a
            class="nav-link"
            id="truck-tab"
            data-toggle="tab"
            href="#truck"
            role="tab"
            >Unidades
          </a>
        </li>
        <li v-if="!showAudit || showTowing" class="nav-item">
          <a
            class="nav-link"
            id="towing-tab"
            data-toggle="tab"
            href="#towing"
            role="tab"
            >Remolques
          </a>
        </li>
        <li v-if="!showAudit || showOperator" class="nav-item">
          <a
            class="nav-link"
            id="operator-tab"
            data-toggle="tab"
            href="#operator"
            role="tab"
            >Operadores
          </a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="line" role="tabpanel">
          <EditLineComponent/>
        </div>
        <div class="tab-pane fade" id="reference" role="tabpanel">
          <ReferenceComponent/>
        </div>
        <div class="tab-pane fade" id="truck" role="tabpanel">
          <TruckComponent/>
        </div>
        <div class="tab-pane fade" id="towing" role="tabpanel">
          <TowingComponent/>
        </div>
        <div class="tab-pane fade" id="operator" role="tabpanel">
          <OperatorComponent/>
        </div>
      </div>

      <div
        v-if="showAudit && showReference"
        class="col-12 border border-info rounded"
      >
        <form class="row" ref="lineAuditForm" @change="checkLineAuditForm">
          <h4 class="col-12 my-3">
            <i class="fa fa-search"></i>
            Auditoria de Linea
          </h4>

          <div class="col-6 px-5">
            <div class="form-group">
              <input
                required
                type="checkbox"
                class="form-check-control"
                v-model="lineAudit.address_ine_rfc_check"
              ></input>
              <label class="m-0">Comprobante de domicilio coincide con INE/RFC</label>
            </div>
            <div class="form-group m-0">
              <input
                required
                type="checkbox"
                class="form-check-control"
                v-model="lineAudit.sat_active_check"
              ></input>
              <label class="m-0">Esta activo con SAT</label>
            </div>
          </div>

          <div class="col-6 px-5">
            <div class="form-group">
              <input
                required
                type="checkbox"
                class="form-check-control"
                v-model="lineAudit.letter_ine_rfc_address_check"
              ></input>
              <label class="m-0">Coincide Carta Porte con INE/RFC y comprobante de domicilio</label>
            </div>
            <div class="form-group m-0">
              <input
                required
                type="checkbox"
                class="form-check-control"
                v-model="lineAudit.ine_rfc_check"
              ></input>
              <label class="m-0">INE coincide con RFC</label>
            </div>
          </div>
        </form>

        <div class="row py-3 px-0">
          <div class="col text-left">
            <button
              @click="assignAccounts"
              class="btn btn-link text-center"
              ><i class="fa fa-dollar-sign"></i> Asignar Cuentas
            </button>
            <button
              @click="assignAgents"
              class="btn btn-link text-center"
              ><i class="fa fa-running"></i> Asignar Agentes
            </button>
          </div>
          <div class="col text-right">
            <router-link
              to="/internalAudit"
              class="btn btn-light text-center"
              ><i class="fa fa-arrow-circle-left"></i> Cancelar
            </router-link>
            <button
              class="btn btn-danger text-center"
              @click="changeStatusModal(false)"
              ><i class="fa fa-times"></i> Rechazar
            </button>
            <button
              :disabled="validateLineAuditForm"
              class="btn btn-success text-center"
              @click="changeStatusModal(true)"
              ><i class="fa fa-check"></i> Aprobar
            </button>
          </div>
        </div>
      </div>

      <div
        v-if="showAudit && showTruck"
        class="col-12 border border-info rounded"
      >
        <form class="row" ref="truckAuditForm" @change="checkTruckAuditForm">
          <h4 class="col-12 my-3">
            <i class="fa fa-search"></i>
            Auditoria de Unidades
          </h4>

          <div class="col-4 px-5">
            <div class="form-group">
              <input
                required
                type="checkbox"
                class="form-check-control"
                v-model="truckAudit.address_ine_rfc_check"
              ></input>
              <label class="m-0">Tarjeta circulacion vs placa</label>
            </div>
            <div class="form-group">
              <input
                required
                type="checkbox"
                class="form-check-control"
                v-model="truckAudit.circulation_card_line_owner_check"
              ></input>
              <label class="m-0">Tarjeta circulacion vs dueño de linea</label>
            </div>
          </div>

          <div class="col-4 px-5">
            <div class="form-group">
              <input
                required
                type="checkbox"
                class="form-check-control"
                v-model="truckAudit.insurance_police_valid_check"
              ></input>
              <label class="m-0">Poliza de seguro vigente</label>
            </div>
            <div class="form-group">
              <input
                required
                type="checkbox"
                class="form-check-control"
                v-model="truckAudit.police_line_owner_check"
              ></input>
              <label class="m-0">Poliza vs RFC dueño de linea</label>
            </div>
          </div>

          <div class="col-4 px-5">
            <div class="form-group">
              <input
                required
                type="checkbox"
                class="form-check-control"
                v-model="truckAudit.photos_match_truck_check"
              ></input>
              <label class="m-0">Fotos coinciden con unidad</label>
            </div>
            <div class="form-group">
              <input
                required
                type="checkbox"
                class="form-check-control"
                v-model="truckAudit.truck_has_no_theft_check"
              ></input>
              <label class="m-0">Unidad no tiene reporte de robo</label>
            </div>
          </div>
        </form>

        <div class="row pb-3 px-0">
          <div class="col-4 px-5">
            <div class="form-group m-0">
              <label class="m-0">Vigencia del seguro</label>
              <input
                required
                type="text"
                class="form-control"
                placeholder="Ingresar vigencia del seguro"
                v-model="truckAudit.insurance_deadline"
              ></input>
            </div>
          </div>
          <div class="col text-right align-self-end">
            <router-link
              to="/internalAudit"
              class="btn btn-light text-center"
              ><i class="fa fa-arrow-circle-left"></i> Cancelar
            </router-link>
            <button
              class="btn btn-danger text-center"
              @click="changeStatusModal(false)"
              ><i class="fa fa-times"></i> Rechazar
            </button>
            <button
              :disabled="validateTruckAuditForm"
              class="btn btn-success text-center"
              @click="changeStatusModal(true)"
              ><i class="fa fa-check"></i> Aprobar
            </button>
          </div>
        </div>
      </div>

      <div
        v-if="showAudit && showTowing"
        class="col-12 border border-info rounded"
      >
        <form class="row" ref="towingAuditForm" @change="checkTowingAuditForm">
          <h4 class="col-12 my-3">
            <i class="fa fa-search"></i>
            Auditoria de Remolques
          </h4>

          <div class="col-6 px-5">
            <div class="form-group">
              <input
                required
                type="checkbox"
                class="form-check-control"
                v-model="towingAudit.circulation_card_plates_check"
              ></input>
              <label class="m-0">Tarjeta de circulacion vs placa</label>
            </div>
            <div class="form-group m-0">
              <input
                required
                type="checkbox"
                class="form-check-control"
                v-model="towingAudit.circulation_card_line_owner_check"
              ></input>
              <label class="m-0">Tarjeta de circulacion vs dueño de linea</label>
            </div>
          </div>

          <div class="col-6 px-5">
            <div class="form-group">
              <input
                required
                type="checkbox"
                class="form-check-control"
                v-model="towingAudit.photos_match_towing_check"
              ></input>
              <label class="m-0">Fotos coinciden con el remolque</label>
            </div>
            <div class="form-group m-0">
              <input
                required
                type="checkbox"
                class="form-check-control"
                v-model="towingAudit.towing_has_no_theft_check"
              ></input>
              <label class="m-0">Remolque no tiene reporte de robo</label>
            </div>
          </div>
        </form>

        <div class="row py-3 px-0">
          <div class="col text-right">
            <router-link
              to="/internalAudit"
              class="btn btn-light text-center"
              ><i class="fa fa-arrow-circle-left"></i> Cancelar
            </router-link>
            <button
              class="btn btn-danger text-center"
              @click="changeStatusModal(false)"
              ><i class="fa fa-times"></i> Rechazar
            </button>
            <button
              :disabled="validateTowingAuditForm"
              class="btn btn-success text-center"
              @click="changeStatusModal(true)"
              ><i class="fa fa-check"></i> Aprobar
            </button>
          </div>
        </div>
      </div>

      <div
        v-if="showAudit && showOperator"
        class="col-12 border border-info rounded"
      >
        <form class="row" ref="operatorAuditForm" @change="checkOperatorAuditForm">
          <h4 class="col-12 my-3">
            <i class="fa fa-search"></i>
            Auditoria de Operadores
          </h4>

          <div class="col-4 px-5">
            <div class="form-group">
              <input
                required
                type="checkbox"
                class="form-check-control"
                v-model="operatorAudit.health_letter_valid_check"
              ></input>
              <label class="m-0">Apto medico vigente</label>
            </div>
            <div class="form-group">
              <label class="m-0">Vigencia del seguro</label>
              <input
                required
                class="form-control"
                type="text"
                placeholder="Ingresar vigencia del seguro"
                v-model="operatorAudit.insurance_deadline"
              ></input>
            </div>
          </div>

          <div class="col-4 px-5">
            <div class="form-group">
              <input
                required
                type="checkbox"
                class="form-check-control"
                v-model="operatorAudit.imss_operator_check"
              ></input>
              <label class="m-0">IMSS coincide con operador</label>
            </div>
            <div class="form-group">
              <input
                required
                type="checkbox"
                class="form-check-control"
                v-model="operatorAudit.driver_license_valid_check"
              ></input>
              <label class="m-0">Licencia vigente</label>
            </div>
          </div>

          <div class="col-4 px-5">
            <div class="form-group">
              <input
                required
                type="checkbox"
                class="form-check-control"
                v-model="operatorAudit.imss_line_owner_check"
              ></input>
              <label class="m-0">IMSS coincide con dueño de linea</label>
            </div>
            <div class="form-group">
              <input
                required
                type="checkbox"
                class="form-check-control"
                  v-model="operatorAudit.photo_sct_driver_license_check"
              ></input>
              <label class="m-0">Foto de SCT coincide con licencia</label>
            </div>
          </div>
        </form>

        <div class="row py-3 px-0">
          <div class="col text-left">
            <button
              @click="assignAccounts"
              class="btn btn-link text-center"
              ><i class="fa fa-dollar-sign"></i> Asignar Cuentas
            </button>
          </div>
          <div class="col text-right">
            <router-link
              to="/internalAudit"
              class="btn btn-light text-center"
              ><i class="fa fa-arrow-circle-left"></i> Cancelar
            </router-link>
            <button
              class="btn btn-danger text-center"
              @click="changeStatusModal(false)"
              ><i class="fa fa-times"></i> Rechazar
            </button>
            <button
              :disabled="validateOperatorAuditForm"
              class="btn btn-success text-center"
              @click="changeStatusModal(true)"
              ><i class="fa fa-check"></i> Aprobar
            </button>
          </div>
        </div>
      </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="checkOutModal" tabindex="-1" role="dialog">
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

    <div class="modal fade" id="assignAccountsModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Asignacion de Cuentas Bancarias</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="row">

              <div class="form-group col-4">
                <label class="required m-0">Banco (1):</label>
                <input
                  required
                  class="form-control"
                  placeholder="Ingresar nombre del banco"
                >
              </div>
              <div class="form-group col-4">
                <label class="required m-0">Tarjeta/Cuenta (1):</label>
                <input
                  required
                  class="form-control"
                  placeholder="Ingresar numero de cuenta"
                >
              </div>
              <div class="form-group col-4">
                <label class="required m-0">Beneficiario (1):</label>
                <input
                  required
                  class="form-control"
                  placeholder="Ingresar nombre de benficiario"
                >
              </div>

              <div class="form-group col-4">
                <label class="m-0">Banco (2):</label>
                <input
                  class="form-control"
                  placeholder="Banorte"
                >
              </div>
              <div class="form-group col-4">
                <label class="m-0">Tarjeta/Cuenta (2):</label>
                <input
                  class="form-control"
                  placeholder="XXXX XXXX XXXX XXXX"
                >
              </div>
              <div class="form-group col-4">
                <label class="m-0">Beneficiario (2):</label>
                <input
                  class="form-control"
                  placeholder="Adan Rodriguez"
                >
              </div>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary">Guardar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="assignAgentsModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Asignacion de Agentes - Trafico</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="row">

              <div class="form-group col-6">
                <select
                  required
                  class="form-control"
                >
                  <option value="" selected disabled>Elegir agente de trafico</option>
                  <option>Zehiael Ramos</option>
                  <option>Adan Rodriguez</option>
                  <option>Victor de Trafico</option>
                  <option>Miguel Unidades Propias</option>
                </select>
              </div>

              <div class="form-group col text-right">
                <button type="button" class="btn btn-light">Agregar Agente</button>
              </div>

              <table class="table table-hover">
                <thead class="thead-light">
                  <tr>
                    <th>Nombre</th>
                    <th>Perfil</th>
                    <th class="text-center">Fecha de Asignacion</th>
                    <th class="text-center">Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="trafficUser in trafficUsers" :key="trafficUser.id">
                    <td class="py-1">{{ trafficUser.name }}</td>
                    <td class="py-1">{{ trafficUser.profile }}</td>
                    <td class="py-1 text-center">{{ trafficUser.created_at }}</td>
                    <td class="text-center">
                      <div class="btn-group" role="group">
                        <div class="py-1">
                          <i
                            data-toggle="tooltip"
                            data-placement="top"
                            title="Eliminar"
                            class="fa fa-trash text-danger handle"
                            @click="deleteProvider(trafficUser.id)"
                          ></i>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary">Guardar</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
  import EditLineComponent from "./EditLineComponent.vue";
  import ReferenceComponent from "./ReferenceComponent.vue";
  import TruckComponent from "./TruckComponent.vue";
  import TowingComponent from "./TowingComponent.vue";
  import OperatorComponent from "./OperatorComponent.vue";

  export default {
    name: 'EditProviderComponent',
    components: {
      EditLineComponent,
      ReferenceComponent,
      TruckComponent,
      TowingComponent,
      OperatorComponent,
    },
    data() {
      return {
        lineAudit: {
          address_ine_rfc_check: false,
          letter_ine_rfc_address_check: false,
          sat_active_check: false,
          ine_rfc_check: false,
        },
        truckAudit: {
          insurance_deadline: '',
          address_ine_rfc_check: false,
          circulation_card_line_owner_check: false,
          truck_has_no_theft_check: false,
          insurance_police_valid_check: false,
          photos_match_truck_check: false,
          police_line_owner_check: false,
        },
        towingAudit: {
          circulation_card_plates_check: false,
          circulation_card_line_owner_check: false,
          photos_match_towing_check: false,
          towing_has_no_theft_check: false,
        },
        operatorAudit: {
          insurance_deadline: '',
          imss_operator_check: false,
          imss_line_owner_check: false,
          driver_license_valid_check: false,
          health_letter_valid_check: false,
          photo_sct_driver_license_check: false,
        },
        trafficUsers: [
          {
            name: 'John Doe',
            profile: 'Mensajero',
            created_at: '15/12/2020',
          },
        ],
        status: {
          pending: 1,
          review: 2,
          reject: 3,
          approve: 4,
        },
        obj: {},
        URI: '',
        module: '',
        showAudit: false,
        modalMode: false,
        validateLineAuditForm: true,
        validateTruckAuditForm: true,
        validateTowingAuditForm: true,
        validateOperatorAuditForm: true,
      }
    },
    mounted() {
      console.log(this.$options.name)
      if (!(this.$route.params.el instanceof Object)) {
        this.$router.push('/providers')
      }
      this.showAudit = this.$route.params.onRevision
      this.showReadOnly = this.$route.params.onReadOnly
      this.showReference = this.$route.params.showReference
      this.showTruck = this.$route.params.showTruck
      this.showTowing = this.$route.params.showTowing
      this.showOperator = this.$route.params.showOperator
      $(this.$route.params.tab).tab('show')
    },
    methods: {
      assignAccounts() {
        $('#assignAccountsModal').modal('show')
      },
      assignAgents() {
        $('#assignAgentsModal').modal('show')
      },
      changeStatusModal(mode) {
        this.modalMode = mode
        this.obj = this.$route.params.el
        this.getTagModule(this.obj.vgt_id)
        $('#checkOutModal').modal('show')
      },
      getTagModule(id) {
        switch ( id ) {
          case 0:
            this.module = 'Linea'
            this.URI = 'Line'
            break
          case 1:
            this.module = 'Unidad'
            this.URI = 'Truck'
            break
          case 2:
            this.module = 'Remolque'
            this.URI = 'Towing'
            break
          case 3:
            this.module = 'Operador'
            this.URI = 'Operator'
            break
          default:
        }
      },
      selectTab() {
        console.log('this.$route.params.el',this.$route.params.el)
        // $(`#myTab a[href="#${this.$route.params.el}"]`).tab('show')
      },
      setStatus() {
        this.obj.status = this.modalMode ? this.status.approve : this.status.reject
        this.axios
          .post(`${API_URL}setStatus${this.URI}`, this.obj)
          .then(resp => {
            this.obj = {}
            $('#checkOutModal').modal('hide')
            this.$router.push('/internalAudit')
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
      checkLineAuditForm() {
        this.validateLineAuditForm = !this.$refs.lineAuditForm.checkValidity()
      },
      checkTruckAuditForm() {
        this.validateTruckAuditForm = !this.$refs.truckAuditForm.checkValidity()
      },
      checkTowingAuditForm() {
        this.validateTowingAuditForm = !this.$refs.towingAuditForm.checkValidity()
      },
      checkOperatorAuditForm() {
        this.validateOperatorAuditForm = !this.$refs.operatorAuditForm.checkValidity()
      },
    }
  }
</script>
