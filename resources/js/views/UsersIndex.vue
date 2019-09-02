<template>
    <div class="users">
        <div v-if="error" class="alert alert-warning mt-3" role="alert">
            {{ error }}
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mt-3 mb-3">Lista de usuários</h2>
            <router-link :to="{ name: 'users.create' }" tag="button" class="btn btn-secondary">Adicionar usuário</router-link>
        </div>

        <table class="table table-hover" v-if="users">
            <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">E-mail</th>
                <th scope="col">Telefone</th>
                <th scope="col">Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="({ id, name, email, telefone }, index) in users">
                <td>{{ name }}</td>
                <td>{{ email }}</td>
                <td>{{ telefone.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3') }}</td>
                <td>
                    <router-link :to="{ name: 'users.edit', params: { id } }" tag="button" class="btn btn-outline-secondary">Editar</router-link>
                    <button @click.prevent="onDelete(id, index)" class="btn btn-outline-danger">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <nav aria-label="...">
            <ul class="pagination justify-content-end">
                <li class="page-item" v-bind:class="{ disabled: !prevPage }">
                    <a class="page-link" href="#" tabindex="-1" @click.prevent="goToPrev">Anterior</a>
                </li>

                <li v-for="{ pageItem, active } in pageCounter" class="page-item" v-bind:class="{ active: active }">
                    <a href="#" class="page-link" @click.prevent="goToPage(pageItem)">
                        {{ pageItem }} <span class="sr-only">(current)</span>
                    </a>
                </li>

                <li class="page-item" v-bind:class="{ disabled: !nextPage }">
                    <a class="page-link" href="#" @click.prevent="goToNext">Próxima</a>
                </li>
            </ul>
        </nav>

        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-outline-secondary" href="http://localhost/api/users/pdf">Relatório de usuários</a>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import api from '../api/users';
    import Swal from 'sweetalert2';

    const getUsers = (page, callback) => {
        const params = {page};

        axios.get('/api/users', {params})
            .then(response => {
                callback(null, response.data);
            }).catch(error => {
                callback(error, error.response.data);
            });
    };

    export default {
        data() {
            return {
                users: null,
                meta: null,
                links: {
                    first: null,
                    last: null,
                    next: null,
                    prev: null,
                },
                error: null,
            };
        },
        computed: {
            nextPage() {
                if (!this.meta || this.meta.current_page === this.meta.last_page) {
                    return;
                }

                return this.meta.current_page + 1;
            },
            prevPage() {
                if (!this.meta || this.meta.current_page === 1) {
                    return;
                }

                return this.meta.current_page - 1;
            },
            pageCounter() {
                if (!this.meta) {
                    return;
                }

                const {current_page, last_page} = this.meta;

                const pages = [];
                for (var item = 1; item <= last_page; item++) {
                    pages.push({
                        pageItem: item,
                        active: item === current_page,
                    });
                }

                return pages;
            },
        },
        beforeRouteEnter(to, from, next) {
            getUsers(to.query.page, (err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        // when route changes and this component is already rendered,
        // the logic will be slightly different.
        beforeRouteUpdate(to, from, next) {
            this.users = this.links = this.meta = null;
            getUsers(to.query.page, (err, data) => {
                this.setData(err, data);
                next();
            });
        },
        methods: {
            goToPage(page) {
                this.$router.push({
                    query: {
                        page: page,
                    },
                });
            },
            goToNext() {
                this.$router.push({
                    query: {
                        page: this.nextPage,
                    },
                });
            },
            goToPrev() {
                this.$router.push({
                    name: 'users.index',
                    query: {
                        page: this.prevPage,
                    }
                });
            },
            setData(err, {data: users, links, meta}) {
                if (err) {
                    this.error = err.toString();
                } else {
                    this.users = users;
                    this.links = links;
                    this.meta = meta;
                }
            },
            onDelete(id, index) {
                Swal.fire({
                    title: 'Você tem certeza?',
                    text: "Você não poderá reverter isso!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, exclua-o!',
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.value) {
                        api.delete(id)
                            .then((response) => {
                                this.users.splice(index, 1);
                            });
                        Swal.fire(
                            'Deletado!',
                            'Usuário foi deletado.',
                            'success'
                        )
                    }
                });
            },
        }
    }
</script>
