<template>
	<div class="container">
		<div class="row pt-3">

			<div class="col-6">
				<div class="form-group">
					<label class="required m-0">Nombre de Linea:</label>
					<input
						required
						class="form-control"
						placeholder="Ingresar linea"
						v-model='provider.name'
					>
				</div>
				<div class="form-group">
					<label class="m-0">Nombre de Propietario:</label>
					<input
						class="form-control"
						placeholder="Ingresar propietario"
						v-model='provider.owner'
					>
				</div>
				<div class="form-group">
					<label class="m-0">Nombre Coordinador:</label>
					<input
						class="form-control"
						placeholder="Ingresar nombre coordinador"
						v-model='provider.coordinator'
					>
				</div>
				<div class="form-group">
					<label class="m-0">Numero fijo:</label>
					<input
						class="form-control"
						placeholder="Ingresar numero fijo"
						v-model='provider.phone'
					>
				</div>
				<div class="form-group">
					<label class="m-0">Comprobante Domicilio:</label>
					<input
						type="file"
						class="form-control-file"
					>
				</div>
				<div class="form-group">
					<label class="m-0">Carta Porte:</label>
					<input
						type="file"
						class="form-control-file"
					>
				</div>
			</div>

			<div class="col-6">
				<div class="form-group">
					<label class="required m-0">RFC:</label>
					<input
						required
						class="form-control"
						placeholder="Ingresar RFC"
						v-model='provider.rfc'
					>
				</div>
				<div class="form-group">
					<label class="m-0">Telefono Propietario:</label>
					<input
						class="form-control"
						placeholder="Ingresar telefono propietario"
						v-model='provider.owner_phone'
					>
				</div>
				<div class="form-group">
					<label class="m-0">Telefono Coordinador:</label>
					<input
						class="form-control"
						placeholder="Ingresar telefono coordinador"
						v-model='provider.coordinator_phone'
					>
				</div>
				<div class="form-group">
					<label class="m-0">INE Propietario:</label>
					<input
						type="file"
						class="form-control-file"
					>
				</div>
				<div class="form-group">
					<label class="m-0">RFC Propietario:</label>
					<input
						type="file"
						class="form-control-file"
					>
				</div>
			</div>

			<div class="col text-right" v-if="!onRevision && !onReadOnly">
				<button
					v-show="$route.params.onAudit"
					@click="showAuditModal"
					class="btn btn-primary text-center"
      		><i class="fa fa-search"></i> Auditar
				</button>
				<button
					@click="editProvider"
					class="btn btn-success text-center"
      		><i class="fa fa-floppy-o"></i> Guardar
				</button>
				<router-link
					to="/providers"
					class="btn btn-danger"
          ><i class="fa fa-times"></i> Cancelar
				</router-link>
			</div>

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
            	¿Estas seguro que desea enviar a auditaria esta linea?
          	</h5>
        	</div>
        	<div class="modal-footer">
          	<button
            	class="btn"
            	data-dismiss="modal"
            	>Cancelar
          	</button>
          	<button
							@click="setStatus"
            	class="btn btn-primary"
            	data-dismiss="modal"
            	>Aceptar
          	</button>
        	</div>
      	</div>
    	</div>
  	</div>

	</div>
</template>

<script>
	export default {
		name: 'EditLineComponent',
		data() {
			return {
				provider: {
					ine: 'ine.pdf',
					address: 'address.pdf',
					owner_rfc: 'rfc.pdf',
					letter: 'letter.pdf',
				},
        status: {
          review: 2,
        },
				loading: true,
				onRevision: false,
				onReadOnly: false,
			}
		},
		mounted() {
			console.log(this.$options.name)
			this.provider = this.$route.params.el
			if (this.provider.provider_id) {
				this.getProvider()
			}
			this.onRevision = this.$route.params.onRevision
			this.onReadOnly = this.$route.params.onReadOnly
		},
		methods: {
			getProvider() {
        this.axios
          .get(`${API_URL}provider/${this.provider.provider_id}`)
          .then(resp => {
            if (resp.data) {
              this.provider = resp.data
            }
          })
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
			},
			editProvider() {
				this.axios
					.patch(`${API_URL}provider/${this.provider.id}`, this.provider)
					.then(resp => (
							this.$router.push({name: 'listProvider'})
					))
					.catch(err => console.log(err))
					.finally(() => this.loading = false)
			},
			setStatus() {
        this.provider.status = this.status.review
				this.axios
					.post(`${API_URL}setStatusLine`, this.provider)
					.then(resp => (
							this.$router.push({name: 'listProvider'})
					))
					.catch(err => console.log(err))
					.finally(() => this.loading = false)
			},
			showAuditModal() {
				$('#auditModal').modal('show')
			},
		}
	}
</script>

<style scoped>
	.required:before {
  	content:"*";
  	color:red;
	}
	td {
		padding-top: 0px;
		padding-bottom: 0px;
	}
  .handle {
    cursor: pointer;
  }
</style>