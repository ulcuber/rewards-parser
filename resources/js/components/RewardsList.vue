<template>
  <div class="panel panel-default table-responsive">
    <table class="table table-condensed table-striped table-hover">
      <thead>
        <tr>
          <th @click="toggleSort('id')" style="cursor:pointer;">Id</th>
          <th>Name</th>
          <th @click="toggleSort('amount')" style="cursor:pointer;">Amount</th>
          <th @click="toggleSort('collected')" style="cursor:pointer;">Collected (USD)</th>
        </tr>
      </thead>
      <tbody>
        <RewardsListItem v-for="item in sortedRewards" v-bind="item" :key="item.id"/>
      </tbody>
    </table>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import socket from '../utils/socket';

import RewardsListItem from './RewardsListItem';

export default {
  components: {
    RewardsListItem,
  },
  data() {
    return {
      sortField: 'id',
      sortOrder: 'asc',
    };
  },
  computed: {
    ...mapGetters('rewards', {
      rewards: 'getData',
    }),
    sortedRewards() {
      return Array.isArray(this.rewards)
        ? this.rewards.concat().sort((a, b) => {
          if (Number(a[this.sortField]) < Number(b[this.sortField])) {
            return this.sortOrder === 'asc' ? -1 : 1;
          }
          if (Number(a[this.sortField]) > Number(b[this.sortField])) {
            return this.sortOrder === 'asc' ? 1 : -1;
          }
          return 0;
        })
        : [];
    },
  },
  created() {
    this.fetchRewards();
  },
  mounted() {
    this.listenSocket();
  },
  beforeDestroy() {
    this.leaveSocket();
  },
  methods: {
    ...mapActions('rewards', {
      fetchRewards: 'fetchData',
      updateReward: 'updateItem',
    }),
    listenSocket() {
      socket.channel('rewards')
        .listen('RewardAmountUpdatedEvent', (event) => {
          this.updateReward(event.reward);
        });
    },
    leaveSocket() {
      socket.leave('rewards');
    },
    toggleSort(field) {
      if (this.sortField === field) {
        this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
      } else {
        this.sortField = field;
      }
    },
  },
};
</script>
