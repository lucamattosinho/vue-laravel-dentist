# Usa a imagem do Node.js
FROM node:18

# Define o diretório de trabalho
WORKDIR /app

# Copia os arquivos do Vue.js
COPY . .

RUN npm install ant-design-vue

# Instala as dependências
RUN npm install

# Compila a aplicação
RUN npm run build


# Expõe a porta do Vue
EXPOSE 5173

# Comando para rodar o servidor do Vue
CMD ["npm", "run", "dev", "--", "--host"]
