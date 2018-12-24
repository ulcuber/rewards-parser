<template>
  <tr>
    <td>{{ id }}</td>
    <td>{{ name }}</td>
    <td>{{ amount }}</td>
    <td>{{ collected }}</td>
  </tr>
</template>

<script>
export default {
  props: {
    id: Number,
    name: String,
    amount: String,
    collected: String,
  }
}
</script>
