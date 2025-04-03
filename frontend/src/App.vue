<template>
  <div class="container">
    <h2>Lista de Consultas</h2>
    <date-picker v-model="selectedDate" placeholder="Selecione uma data" @change="filterAppointments" />
    <ul>
      <li v-for="appointment in filteredAppointments" :key="appointment.id">
        {{ appointment.date }} - {{ appointment.patientName }}
      </li>
    </ul>
  </div>
</template>

<script>
import { ref, computed } from 'vue';
import { DatePicker } from 'ant-design-vue/es';

export default {
  components: { DatePicker },
  setup() {
    const selectedDate = ref(null);
    const appointments = ref([
      
    ]);

    const filteredAppointments = computed(() => {
      if (!selectedDate.value) return appointments.value;
      return appointments.value.filter(appt => appt.date === selectedDate.value.format('YYYY-MM-DD'));
    });

    return { selectedDate, filteredAppointments };
  },
};
</script>

<style scoped>
.container {
  max-width: 600px;
  margin: auto;
  text-align: center;
}
</style>
