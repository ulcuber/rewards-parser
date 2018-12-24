<template>
    <div class="panel panel-default table-responsive">
        <table class="table table-condensed table-striped table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Collected (USD)</th>
                </tr>
            </thead>
            <tbody>
                <RewardsListItem v-for="item in rewards" v-bind="item" :key="item.id"/>
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
  computed: {
    ...mapGetters('rewards', {
      rewards: 'getData',
    }),
  },
  created() {
    this.fetchRewards();
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
          this.updateReward(event.reward)
        });
    },
    leaveSocket() {
      socket.leave('rewards');
    },
  },
};
</script>
