<template>
    <div class="form-container">
      <a-button type="link" @click="$router.back()" class="back-button">← Voltar</a-button>
      <h2>Cadastrar Consulta</h2>
  
      <a-form layout="vertical" @submit.prevent="handleSubmit">
        <a-form-item label="Paciente">
          <a-select
            v-model:value="form.paciente_id"
            placeholder="Selecione o paciente"
            :options="pacientes.map(p => ({ value: p.id, label: `${p.first_name} ${p.last_name}` }))"
          />
        </a-form-item>
  
        <a-form-item label="Data e Hora">
          <a-date-picker
            v-model:value="form.data_hora"
            show-time
            format="DD/MM/YYYY HH:mm"
            style="width: 100%"
          />
        </a-form-item>
  
        <a-form-item label="Tratamento">
          <a-input v-model:value="form.tratamento" placeholder="Ex: Limpeza dentária" />
        </a-form-item>
  
        <a-form-item label="Descrição">
          <a-textarea v-model:value="form.descricao" rows="4" placeholder="Detalhes do procedimento..." />
        </a-form-item>
  
        <a-form-item>
          <a-button type="primary" html-type="submit" :loading="loading">
            Cadastrar
          </a-button>
        </a-form-item>
      </a-form>
  
      <a-alert
        v-if="successMessage"
        type="success"
        message="Consulta cadastrada com sucesso!"
        show-icon
        closable
        @close="successMessage = false"
      />
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import { Form, Input, DatePicker, Select, Button, Alert } from 'ant-design-vue';
  import axios from 'axios';
  import dayjs from 'dayjs';
  
  export default {
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
    setup() {
      const form = ref({
        paciente_id: null,
        data_hora: null,
        tratamento: '',
        descricao: '',
      });
  
      const pacientes = ref([]);
      const loading = ref(false);
      const successMessage = ref(false);
  
      const fetchPacientes = async () => {
        try {
          const response = await axios.get('http://127.0.0.1:8000/api/pacientes');
          pacientes.value = response.data;
        } catch (err) {
          console.error('Erro ao carregar pacientes:', err);
        }
      };
  
      const handleSubmit = async () => {
        loading.value = true;
        try {
          const payload = {
            ...form.value,
            data_hora: dayjs(form.value.data_hora).format('YYYY-MM-DD HH:mm:ss'),
          };
          await axios.post('http://127.0.0.1:8000/api/consultas', payload);
          successMessage.value = true;
          form.value = {
            paciente_id: null,
            data_hora: null,
            tratamento: '',
            descricao: '',
          };
        } catch (err) {
          console.error('Erro ao cadastrar consulta:', err);
        } finally {
          loading.value = false;
        }
      };
  
      onMounted(() => {
        fetchPacientes();
      });
  
      return {
        form,
        pacientes,
        loading,
        successMessage,
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
    background: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
}

.back-button {
    padding-left: 0;
    margin-bottom: 1rem;
    font-weight: bold;
}
</style>