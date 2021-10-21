<template>
  <div class="container">
    <h3 class="text-center m-0 p-0">Modulo de Analítica</h3>
  </div>
</template>

<script>
  import moment from 'moment';

  export default {
    name: 'AnalyticsComponent',
    data() {
      return {
        providers: {},
      }
    },
    mounted() {
      console.log(this.$options.name)
      this.getProviders()
    },
    methods: {
      getProviders() {
        this.axios
          .get(API_URL + 'client')
          .then(resp => (
              this.providers = resp.data
          ))
          .catch(err => console.log(err))
          .finally(() => this.loading = false)
      },
    }
  }
</script>

<style scoped>

</style>
