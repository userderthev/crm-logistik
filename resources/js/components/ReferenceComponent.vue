<template>
	<div class="container">
		<div class="row pt-3">

			<div class="col-6">
				<div class="form-group">
					<label class="required m-0">Referencia Comercial 1:</label>
					<input
						required
						class="form-control"
						placeholder="Ingresar referencia comercial 1:"
						v-model='reference.trade_one'
					>
				</div>
				<div class="form-group">
					<label class="required m-0">Referencia Comercial 2:</label>
					<input
						required
						class="form-control"
						placeholder="Ingresar referencia comercial 2:"
						v-model='reference.trade_two'
					>
				</div>
				<div class="form-group">
					<label class="required m-0">Referencia Comercial 3:</label>
					<input
						required
						class="form-control"
						placeholder="Ingresar referencia comercial 3:"
						v-model='reference.trade_three'
					>
				</div>
			</div>

			<div class="col-6">
				<div class="form-group">
					<label class="required m-0">Tel Referencia Comercial 1:</label>
					<input
						required
						class="form-control"
						placeholder="Ingresar tel referencia comercial 1"
						v-model='reference.tel_trade_one'
					>
				</div>
				<div class="form-group">
					<label class="required m-0">Tel Referencia Comercial 2:</label>
					<input
						required
						class="form-control"
						placeholder="Ingresar tel referencia comercial 2"
						v-model='reference.tel_trade_two'
					>
				</div>
				<div class="form-group">
					<label class="required m-0">Tel Referencia Comercial 3:</label>
					<input
						required
						class="form-control"
						placeholder="Ingresar tel referencia comercial 3"
						v-model='reference.tel_trade_three'
					>
				</div>
			</div>

			<div class="col text-right" v-if="!$route.params.onRevision && !$route.params.onReadOnly">
				<button
					@click="addReference"
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
	</div>
</template>

<script>
	export default {
		name: 'ReferenceComponent',
		data() {
			return {
				reference: {},
			}
		},
		mounted() {
			console.log(this.$options.name)
			this.getReference()
		},
		methods: {
			getReference() {
				this.axios
					.get(`${API_URL} ${this.$route.params.el.id}/getReferences`)
					.then(resp => {
						if (resp.data) {
							this.reference = resp.data
						}
					})
					.catch(err => console.log(err))
					.finally(() => this.loading = false)
			},
			addReference() {
				this.reference.provider_id = this.$route.params.el.id
				this.axios
					.post(API_URL + 'provider/reference', this.reference)
					.then(resp => (
						this.$router.push({name: 'listProvider'})
					))
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