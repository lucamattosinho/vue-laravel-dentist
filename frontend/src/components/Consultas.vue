<template>
    <div>
      <h2>Consultas</h2>
      <a-space direction="vertical" style="width: 100%">
        <a-date-picker
          v-model:value="selectedDate"
          placeholder="Filtrar por data"
          @change="filterAppointments"
          style="width: 100%"
        />
        <a-list bordered :data-source="filteredAppointments">
          <template #renderItem="{ item }">
            <a-list-item>
              <strong>{{ item.date }}</strong> - {{ item.patientName }}
            </a-list-item>
          </template>
        </a-list>
      </a-space>
    </div>
  </template>
  
  <script>
  import { ref, computed } from 'vue';
  import { DatePicker, List, Space } from 'ant-design-vue';
  
  export default {
    components: {
      'a-date-picker': DatePicker,
      'a-list': List,
      'a-list-item': List.Item,
      'a-space': Space,
    },
    setup() {
      const selectedDate = ref(null);
      const appointments = ref([
        { id: 1, date: '2025-04-03', patientName: 'Maria Silva' },
        { id: 2, date: '2025-04-04', patientName: 'João Souza' },
      ]);
  
      const filteredAppointments = computed(() => {
        if (!selectedDate.value) return appointments.value;
        return appointments.value.filter(
          appt => appt.date === selectedDate.value.format('YYYY-MM-DD')
        );
      });
  
      const filterAppointments = () => {
        // só para manter o @change funcionando — computed já cuida do filtro
      };
  
      return {
        selectedDate,
        appointments,
        filteredAppointments,
        filterAppointments,
      };
    },
  };
  </script>
  