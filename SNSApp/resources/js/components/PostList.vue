<template>
    <div>
        <post-message title="投稿一覧" :content='userName + "さんのタイムライン"'> </post-message>
        <table class="table table-striped">
            <tr>
                <th>並びかえ</th>
                <th><a href="#" @click.prevent.stop="fetchposts('/api/posts','user_id')">投稿者</a></th>
                <th><a href="#" @click.prevent.stop="fetchposts('/api/posts','updated_at')">更新日</a></th>
                <th><a href="#" @click.prevent.stop="fetchposts('/api/posts','likes_count')">いいね</a></th>
            </tr>
        </table>

        <div v-for="post in posts">
            <post-component :post="post"></post-component>
        </div>

        <nav class="navbar navbar-expands-sm navbar-dark mb-2">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchposts(pagination.prev )">前</a>
                </li>

                <li class="page-item disabled">
                    <a class="page-link text-dark" href="#">ページ {{pagination.current_page}} /
                        {{pagination.last_page}}</a>
                </li>

                <li v-bind:class="[{disabled: !pagination.next}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchposts(pagination.next)">次</a>
                </li>
            </ul>
        </nav>
    </div>
</template>
<script>
import string from '@babel/template/lib/string';
import Axios from 'axios'

export default {
    data() {
        return {
            posts: [],
            pagination: {},
            sort: string,
            userName: "",
        };
    },
    created() {
        this.fetchposts("/api/posts", "id")
    },
    computed: {
    },
    methods: {
        fetchposts(url, sort) {
            if (sort) {
                this.sort = sort;
            }
            Axios.get(url, {
                params: {
                    sort: this.sort
                }
            }
            )
                .then(response => {
                    this.posts = response.data.data
                    // 直接参照するとプロパティが定義されていないと警告がでるので一旦ローカルに保存する 
                    this.userName = response.data.user.name;
                    this.pagination.current_page = response.data.meta.current_page
                    this.pagination.last_page = response.data.meta.last_page
                    this.pagination.next = response.data.links.next
                    this.pagination.prev = response.data.links.prev
                })
                .catch(error => { alert(error) })
        },
    }
}

</script>