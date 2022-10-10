<template>
    <div>
        <post-message title="投稿一覧" :content='userName + "さんのタイムライン"'> </post-message>
        <table class="table table-striped">
            <tr>
                <th><a href="#" @click.prevent.stop="fetchposts('/api/posts','user-name')" >投稿者</a></th>
                <th><a href="#" @click.prevent.stop="fetchposts('/api/posts','content')" >本文</a></th>
                <th><a href="#" @click.prevent.stop="fetchposts('/api/posts','image')" >画像</a></th>
                <th><a href="#" @click.prevent.stop="fetchposts('/api/posts','like')" >いいね</a></th>
                <th></th>
            </tr>
            <tr v-for="post in posts.data">
                <td>{{post.user_id }}</td>
                <td>{{post.content }}</td>
                <td>
                    <img :src="imagePath(post)" width="100%">
                </td>
                <td v-if="post.isLiked">
                    <button type="button" class="btn btn-success" @click="unlikepost(post.id)">いいね{{post.likesCount}}</button>
                </td>
                <td v-else>
                    <button type="button" class="btn btn-secondary" @click="likepost(post.id)">いいね</button>
                </td>
                <td><button type="button" class="btn btn-danger" @click="deletepost(post.id)">削除</button></td>
            </tr>
        </table>
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
            sort:string,
            userName:"",
        };
    },
    created() {
        this.fetchposts("/api/posts","id")
    },
    computed: {
    },
    methods: {
        imagePath(post){
            return '/storage/'+ post.image
        },
        fetchposts(url,sort) {
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
                    this.posts = response.data
                    // 直接参照するとプロパティが定義されていないと警告がでるので一旦ローカルに保存する 
                    this.userName = this.posts.user.name;
                    this.pagination.current_page = this.posts.meta.current_page
                    this.pagination.last_page = this.posts.meta.last_page
                    this.pagination.next = this.posts.links.next
                    this.pagination.prev = this.posts.links.prev                    
                })
                .catch(error => { alert(error) })
        },
        likepost(postId) {
            let url = `/api/like/${postId}`
            Axios.post(url)
                    .then(Response => {
                        //リダイレクト
                        location.href = "/"
                    })
                    .catch(error => { alert(error) })
        },
        unlikepost(postId) {
            let url = `/api/unlike/${postId}`
            Axios.post(url)
                    .then(Response => {
                        //リダイレクト
                        location.href = "/"
                    })
                    .catch(error => { alert(error) })
        },
        editpost(postId) {
            let url = `/post/edit/${postId}`
            location.href = url;
        },

        deletepost(postId) {
            let url = `/api/posts/${postId}`
            if (confirm("削除してよろしいですか？")) {
                Axios.delete(url)
                    .then(Response => {
                        //リダイレクト
                        location.href = "/"
                    })
                    .catch(error => { alert(error) })
            }
        }
    }
}

</script>