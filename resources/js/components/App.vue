<template>
  <div>
    <RewardsList/>
  </div>
</template>

<script>
import RewardsList from './RewardsList.vue';

export default {
  name: 'app',
  components: {
    RewardsList,
  },
};
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 0px;
}
</style>
