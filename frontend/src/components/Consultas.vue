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
      <a-list
        bordered
        :data-source="filteredAppointments"
        :loading="carregando"
      >
        <template #renderItem="{ item }">
          <a-list-item>
            <strong>{{ formatDate(item.data_hora) }}</strong> - {{ item.paciente.first_name }} {{ item.paciente.last_name }}
          </a-list-item>
        </template>
      </a-list>
    </a-space>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import { DatePicker, List, Space } from 'ant-design-vue';
import axios from 'axios';
import dayjs from 'dayjs';

export default {
  components: {
    'a-date-picker': DatePicker,
    'a-list': List,
    'a-list-item': List.Item,
    'a-space': Space,
  },
  setup() {
    const selectedDate = ref(null);
    const appointments = ref([]);
    const carregando = ref(true);

    const loadAppointments = async () => {
      try {
        const res = await axios.get('http://127.0.0.1:8000/api/consultas');
        appointments.value = res.data;
      } catch (err) {
        console.error('Erro ao carregar consultas:', err);
      } finally {
        carregando.value = false;
      }
    };

    const filteredAppointments = computed(() => {
      if (!selectedDate.value) return appointments.value;
      return appointments.value.filter(appt =>
        dayjs(appt.data_hora).format('YYYY-MM-DD') === selectedDate.value.format('YYYY-MM-DD')
      );
    });

    const filterAppointments = () => {
      // só pra manter o @change
    };

    const formatDate = (dt) => {
      return dayjs(dt).format('DD/MM/YYYY HH:mm');
    };

    onMounted(() => {
      loadAppointments();
    });

    return {
      selectedDate,
      appointments,
      filteredAppointments,
      filterAppointments,
      formatDate,
      carregando,
    };
  },
};
</script>
