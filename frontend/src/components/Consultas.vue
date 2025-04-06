<template>
  <div>
    <div class="titulo-header">
      <h2>Consultas</h2>
      <a-button type="primary" @click=irParaCadastro>
        + Marcar
      </a-button>
    </div>
    <a-space direction="vertical" style="width: 100%">
      <div class="form-row">
        <a-input
          v-model:value="nameFilter"
          placeholder="Filtrar por nome"
          style="width: 100%"
          @input="filterName"
          class="form-half"
        />
        <a-date-picker
          v-model:value="selectedDate"
          placeholder="Filtrar por data"
          @change="filterAppointments"
          style="width: 100%"
          class="form-half"
        />
      </div>
      <a-list
        bordered
        :data-source="filteredAppointments"
        :loading="carregando"
      >
        <template #renderItem="{ item }">
          <a-list-item>
            <strong>{{ formatDate(item.data_hora) }}</strong> - {{ item.paciente.first_name }} {{ item.paciente.last_name }}
            <template #actions>
              <a @click="editarConsulta(item.id)">Editar</a>
              <a-popconfirm
                title="Tem certeza que deseja excluir esta consulta?"
                ok-text="Sim"
                cancel-text="Não"
                @confirm="deletarConsulta(item.id)"
              >
                <a style="color: red">Excluir</a>
              </a-popconfirm>
            </template>
          </a-list-item>
        </template>
      </a-list>
    </a-space>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import { DatePicker, List, Space, Input } from 'ant-design-vue';
import axios from 'axios';
import dayjs from 'dayjs';
import { useRouter } from 'vue-router';

export default {
  components: {
    'a-date-picker': DatePicker,
    'a-list': List,
    'a-list-item': List.Item,
    'a-space': Space,
    'a-input': Input,
  },
  setup() {
    const selectedDate = ref(null);
    const appointments = ref([]);
    const carregando = ref(true);
    const nameFilter = ref('');
    const router = useRouter();
  
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
      return appointments.value.filter((appt) => {
        const matchesDate = !selectedDate.value || dayjs(appt.data_hora).format('YYYY-MM-DD') === selectedDate.value.format('YYYY-MM-DD');
        const nomeCompleto = `${appt.paciente.first_name} ${appt.paciente.last_name}`.toLowerCase();
        const matchesName = !nameFilter.value || nomeCompleto.includes(nameFilter.value.toLowerCase());
        return matchesDate && matchesName;
      });
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

    const irParaCadastro = () => {
      router.push('/consultas/cadastrar');
    };

    const deletarConsulta = async (id) => {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/consultas/${id}`);
        await carregarPacientes(); // recarrega a lista
      } catch (err) {
        console.error("Erro ao deletar paciente:", err);
      }
    };

    const editarConsulta = (id) => {
      router.push(`/consultas/editar/${id}`);
    };

    return {
      selectedDate,
      appointments,
      filteredAppointments,
      filterAppointments,
      formatDate,
      carregando,
      nameFilter,
      irParaCadastro,
      deletarConsulta,
      editarConsulta,
    };
  },
};
</script>

<style scoped>

.titulo-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}

.form-row {
  display: flex;
  gap: 1rem;
}

.form-half {
  flex: 1;
}
</style>
