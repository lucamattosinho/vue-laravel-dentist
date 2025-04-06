<template>
  <div class="form-container">
    <a-button type="link" @click="$router.back()" class="back-button">← Voltar</a-button>
    <h2>{{ modo === 'editar' ? 'Editar Paciente' : 'Cadastrar Paciente' }}</h2>

    <a-form layout="vertical" @submit.prevent="handleSubmit">
      <a-form-item label="Nome">
        <a-input v-model:value="form.first_name" placeholder="João" />
      </a-form-item>

      <a-form-item label="Sobrenome">
        <a-input v-model:value="form.last_name" placeholder="Silva" />
      </a-form-item>

      <div class="form-row">
        <a-form-item label="CPF" class="form-half">
          <a-input v-model:value="form.cpf" placeholder="000.000.000-00" />
        </a-form-item>

        <a-form-item label="Telefone" class="form-half">
          <a-input v-model:value="form.phone" placeholder="(00) 00000-0000" />
        </a-form-item>
      </div>

      <a-form-item>
        <a-button type="primary" html-type="submit" :loading="loading">
          {{ modo === 'editar' ? 'Salvar alterações' : 'Cadastrar' }}
        </a-button>
      </a-form-item>
    </a-form>

    <a-alert
      v-if="successMessage"
      message="Paciente salvo com sucesso!"
      type="success"
      show-icon
      closable
      @close="successMessage = false"
    />
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { Form, Input, Button, Alert } from 'ant-design-vue';
import axios from 'axios';

export default {
  props: {
    modo: {
      type: String,
      default: 'cadastrar', // ou 'editar'
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
    'a-button': Button,
    'a-alert': Alert,
  },
  setup(props) {
    const form = ref({
      first_name: '',
      last_name: '',
      cpf: '',
      phone: '',
    });

    const loading = ref(false);
    const successMessage = ref(false);

    onMounted(async () => {
      if (props.modo === 'editar' && props.id) {
        try {
          const res = await axios.get(`http://127.0.0.1:8000/api/pacientes/${props.id}`);
          form.value = res.data;
        } catch (err) {
          console.error('Erro ao carregar paciente:', err);
        }
      }
    });

    const handleSubmit = async () => {
      loading.value = true;
      try {
        if (props.modo === 'editar') {
          await axios.put(`http://127.0.0.1:8000/api/pacientes/${props.id}`, form.value);
        } else {
          await axios.post('http://127.0.0.1:8000/api/pacientes', form.value);
        }
        successMessage.value = true;
      } catch (err) {
        console.error('Erro ao salvar paciente:', err);
      } finally {
        loading.value = false;
      }
    };

    return {
      form,
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
