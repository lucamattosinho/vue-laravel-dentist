<template>
  <div class="form-container">
    <a-button type="link" @click="$router.back()" class="back-button">← Voltar</a-button>
    <h2>{{ modo === 'editar' ? 'Editar Consulta' : 'Marcar Consulta' }}</h2>

    <a-form layout="vertical" @submit.prevent="handleSubmit">
      <a-form-item label="Paciente">
        <a-select
          v-model:value="form.paciente_id"
          placeholder="Selecione um paciente"
          :options="pacienteOptions"
        />
      </a-form-item>

      <a-form-item label="Data e Hora">
        <a-date-picker
          v-model:value="form.data_hora"
          show-time
          format="YYYY-MM-DD HH:mm"
          style="width: 100%"
        />
      </a-form-item>

      <a-form-item label="Tratamento">
        <a-input v-model:value="form.tratamento" placeholder="Ex: Limpeza" />
      </a-form-item>

      <a-form-item label="Descrição">
        <a-textarea
          v-model:value="form.descricao"
          placeholder="Observações..."
          rows="4"
        />
      </a-form-item>

      <a-form-item>
        <a-button type="primary" html-type="submit" :loading="loading">
          {{ modo === 'editar' ? 'Salvar alterações' : 'Marcar' }}
        </a-button>
      </a-form-item>
    </a-form>

    <a-alert
      v-if="successMessage"
      message="Consulta salva com sucesso!"
      type="success"
      show-icon
      closable
      @close="successMessage = false"
    />
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import {
  Form,
  Input,
  Button,
  Alert,
  Select,
  DatePicker,
} from 'ant-design-vue';
import axios from 'axios';
import dayjs from 'dayjs';

export default {
  props: {
    modo: {
      type: String,
      default: 'cadastrar',
    },
    id: {
      type: String,
      default: null,
    },
  },
  components: {
    'a-form': Form,
    'a-form-item': Form.Item,
    'a-input': Input,
    'a-textarea': Input.TextArea,
    'a-button': Button,
    'a-alert': Alert,
    'a-select': Select,
    'a-date-picker': DatePicker,
  },
  setup(props) {
    const form = ref({
      paciente_id: null,
      data_hora: null,
      tratamento: '',
      descricao: '',
    });

    const loading = ref(false);
    const successMessage = ref(false);
    const pacienteOptions = ref([]);

    const carregarPacientes = async () => {
      try {
        const res = await axios.get('http://127.0.0.1:8000/api/pacientes');
        pacienteOptions.value = res.data.map(p => ({
          label: `${p.first_name} ${p.last_name}`,
          value: p.id,
        }));
      } catch (err) {
        console.error('Erro ao carregar pacientes:', err);
      }
    };

    const carregarConsulta = async () => {
      if (props.modo === 'editar' && props.id) {
        try {
          const res = await axios.get(`http://127.0.0.1:8000/api/consultas/${props.id}`);
          form.value = {
            paciente_id: res.data.paciente_id,
            data_hora: dayjs(res.data.data_hora), // IMPORTANTE para o date-picker
            tratamento: res.data.tratamento,
            descricao: res.data.descricao,
          };
        } catch (err) {
          console.error('Erro ao carregar consulta:', err);
        }
      }
    };

    const handleSubmit = async () => {
      loading.value = true;
      try {
        const payload = {
          ...form.value,
          data_hora: form.value.data_hora.format('YYYY-MM-DD HH:mm:ss'),
        };

        if (props.modo === 'editar') {
          await axios.put(`http://127.0.0.1:8000/api/consultas/${props.id}`, payload);
        } else {
          await axios.post('http://127.0.0.1:8000/api/consultas', payload);
        }

        successMessage.value = true;
      } catch (err) {
        console.error('Erro ao salvar consulta:', err);
      } finally {
        loading.value = false;
      }
    };

    onMounted(async () => {
      await carregarPacientes(); // carrega os nomes primeiro
      await carregarConsulta();  // só depois preenche o form
    });

    return {
      form,
      loading,
      successMessage,
      pacienteOptions,
      handleSubmit,
    };
  },
};
</script>

<style scoped>
.form-container {
  max-width: 1800px;
  min-width: 800px;
  margin: 0 auto;
  padding: 2rem;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}
.form-row {
  display: flex;
  gap: 1rem;
}
.form-half {
  flex: 1;
}
.back-button {
    padding-left: 0;
    margin-bottom: 1rem;
    font-weight: bold;
}
</style>
