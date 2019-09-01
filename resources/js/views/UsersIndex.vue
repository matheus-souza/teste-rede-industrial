<template>
    <div class="users">
        <div v-if="error" class="error">
            <p>{{ error }}</p>
        </div>

        <ul v-if="users">
            <li v-for="{ id, name, email, telefone } in users">
                <strong>Name:</strong> {{ name }},
                <strong>Email:</strong> {{ email }}
                <strong>Telefone:</strong> {{ telefone }}
                <router-link :to="{ name: 'users.edit', params: { id } }">Edit</router-link>
            </li>
        </ul>

        <nav aria-label="...">
            <ul class="pagination">
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

        <div>
            <router-link :to="{ name: 'users.create' }">Add User</router-link>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';

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
        }
    }
</script>
