# Usa a imagem do Node.js
FROM node:18

# Define o diretório de trabalho
WORKDIR /app

# Copia apenas os arquivos de dependência primeiro
COPY package*.json ./

# Instala as dependências
RUN npm install

# Copia o restante do projeto
COPY . .

# Compila a aplicação
RUN npm run build

# Expõe a porta do Vite
EXPOSE 5173

# Comando para rodar o servidor de desenvolvimento
CMD ["npm", "run", "dev", "--", "--host"]
