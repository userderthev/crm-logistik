<template>
	<div class="container">
		<h3 class="text-center mb-0">Lista de Proveedores</h3>
		<div class="col text-right p-0 mb-2">
			<router-link
				to="/addProvider"
				class="btn btn-primary"
				><i class="fa fa-plus-circle"></i> Agregar
			</router-link>
		</div>
		<table class="table table-hover">
			<thead class="thead-light">
				<tr>
					<th>Nombre de Linea</th>
					<th class="text-center">RFC</th>
					<th>Nombre Propietario</th>
					<th>Telefono Propietario</th>
					<th>Nombre Coordinador</th>
					<th class="text-center">Status</th>
					<th class="text-center">Opciones</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="provider in providers" :key="provider.id">
					<td class="py-1">{{ provider.name }}</td>
					<td class="py-1">{{ provider.rfc }}</td>
					<td class="py-1">{{ provider.owner }}</td>
					<td class="py-1">{{ provider.owner_phone }}</td>
					<td class="py-1">{{ provider.coordinator }}</td>
					<td class="py-1 text-center text-md">
            <span v-if="provider.status_id == 1" class="badge badge-primary">Pendiente</span>
            <span v-else-if="provider.status_id == 2" class="badge badge-warning">Revision</span>
            <span v-else-if="provider.status_id == 3" class="badge badge-danger">Rechazado</span>
            <span v-else-if="provider.status_id == 4" class="badge badge-success">Aprovado</span>
            <span v-else class="badge badge-secondary">Inhabilitado</span>
					</td>
					<td class="text-center">
						<div class="btn-group" role="group">
							<div class="py-1">
								<router-link
									class="py-1"
									:to="{name: 'editProvider', params: { el: provider, onAudit: true }}"
								>
									<i
										class="fa fa-search text-muted"
										data-toggle="tooltip"
										data-placement="top"
										title="Auditar"
									></i>
								</router-link>
								<router-link
									class="py-1"
									:to="{name: 'editProvider', params: { el: provider, onAudit: false }}"
								>
									<i
										class="fa fa-edit text-muted"
										data-toggle="tooltip"
										data-placement="top"
										title="Editar"
									></i>
								</router-link>
								<i
									data-toggle="tooltip"
									data-placement="top"
									title="Eliminar"
									class="fa fa-trash text-danger handle"
									@click="deleteProvider(provider.id)"
								></i>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
	import moment from 'moment';

	export default {
		name: 'ListProviderComponent',
		data() {
			return {
				providers: {},
				loading: true,
			}
		},
		mounted() {
			console.log(this.$options.name)
			this.getProviders()
		},
		methods: {
				formatDate(date) {
					return moment(date).format('DD/MM/YYYY hh:mm')
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
				deleteProvider(id) {
					this.axios
						.delete(`${API_URL}provider/${id}`)
						.then(resp => {
							if (resp.data) {
								// find index of your object
								let i = this.providers.map(item => item.id).indexOf(id);
								this.providers.splice(i, 1)
							}
						})
						.catch(err => console.log(err))
						.finally(() => this.loading = false)
				},
		}
	}
</script>

<style scoped>
	td {
		padding-top: 0px;
		padding-bottom: 0px;
	}
  .handle {
    cursor: pointer;
  }
</style>