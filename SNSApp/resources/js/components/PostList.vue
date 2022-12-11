<template>
    <div>
        <post-message :title='user.name + "さんのタイムライン"' content=""> </post-message>

        <nav class="navbar navbar-expand-sm navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/user/follows">{{ followsCount }}フォロー</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/user/follows">{{ followersCount }}フォロワー</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/post/create">新規投稿</a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <div class="input-group mr-1">
                        <input type="text" class="form-control" placeholder="検索文字を入力" v-model="keyword"
                        aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" 
                            v-on:click="searchPosts()" id="button-addon2">検索</button>
                        </div>
                    </div>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown">並びかえ</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <button class="dropdown-item" v-on:click="fetchposts('/api/posts', 'user_id')">投稿者</button>
                            <button class="dropdown-item" href="#"
                                v-on:click="fetchposts('/api/posts', 'updated_at')">更新日</button>
                            <button class="dropdown-item" href="#"
                                v-on:click="fetchposts('/api/posts', 'likes_count')">いいね</button>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <div v-for="post in posts">
            <post-component :post="post" ></post-component>
        </div>

        <ul class="pagination">
            <li v-bind:class="[{ disabled: !pagination.prev }]" class="page-item">
                <a class="page-link" href="#" @click="fetchposts(pagination.prev)">前</a>
            </li>

            <li class="page-item disabled">
                <a class="page-link text-dark" href="#">ページ {{ pagination.current_page }} /
                    {{ pagination.last_page }}</a>
            </li>

            <li v-bind:class="[{ disabled: !pagination.next }]" class="page-item">
                <a class="page-link" href="#" @click="fetchposts(pagination.next)">次</a>
            </li>
        </ul>
    </div>
</template>
<script>
import string from '@babel/template/lib/string';

export default {
    data() {
        return {
            posts: [],
            pagination: {},
            sort: string,
            user: {},
            keyword: "",
        };
    },
    created() {
        this.fetchposts("/api/posts", "id")
    },
    computed: {
        followsCount() {
            let count = 0
            if (this.user.follows) {
                count = this.user.follows.length
            }
            return count;
        },
        followersCount() {
            let count = 0
            if (this.user.followers) {
                count = this.user.followers.length
            }
            return count;
        }
    },
    methods: {
        click() {
            alert("error")
        },
        fetchposts(url, sort) {
            if (sort) {
                this.sort = sort;
            }
            axios.get(url, {
                params: {
                    sort: this.sort
                }
            }
            )
                .then(response => {
                    this.updatePosts(response)
                })
                .catch(error => { alert(error) })
        },
        searchPosts(){
            axios.get("/api/posts", {
                params: {
                    keyword: this.keyword
                }
            }
            )
                .then(response => {
                    this.updatePosts(response)
                })
                .catch(error => { alert(error) })
        },
        updatePosts(response) {
            this.posts = response.data.data
            // 直接参照するとプロパティが定義されていないと警告がでるので一旦ローカルに保存する 
            this.user = response.data.user;
            this.pagination.current_page = response.data.meta.current_page
            this.pagination.last_page = response.data.meta.last_page
            this.pagination.next = response.data.links.next
            this.pagination.prev = response.data.links.prev
            // alert(JSON.stringify(response.data.user))

            //store更新
            this.$store.dispatch('setUserAction', this.user)
        }
    }
}

</script>