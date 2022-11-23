<template>
    <div>
        <post-message title="投稿編集フォーム" content="コメントと画像を編集"> </post-message>
        <form @submit.prevent="updatepost" class="my-5">
            <div class="form-group mb-3">
                <label for="inputContent" class="form-label lead">内容</label>
                <textarea class="form-control" id="inputContent" rows="6" v-model="post.content" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label class="form-label lead">画像</label>
                <div v-if="imageurl">
                    <img :src="imageurl" width="100%">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupFileAddon01">画像選択</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input"  @change="uploadFile" accept="image/*"
                            id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="inputGroupFile01" data-browse="参照">{{ imageName }}</label>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <a class="btn btn-secondary" href="/">
                    キャンセル
                </a>
                <button type="submit" class="btn btn-primary">
                    更新する
                </button>
            </div>

        </form>
    </div>
</template>
<script>

export default {
    data() {
        return {
            postId: 0,
            post: {},
            fileInfo: '',
            imageurl: "",
        };
    },
    created() {
        this.postId = location.pathname.substring(location.pathname.lastIndexOf('/') + 1)
        let url = `/api/posts/${this.postId}`
        this.fetchTodo(url)
    },
    computed: {
        imageName() {
            return this.fileInfo ? this.fileInfo.name : "変更なし"
        }
    },
    methods: {
        fetchTodo(url) {
            axios.get(url)
                .then(response => {
                    this.post = response.data.data
                    this.imageurl = '/storage/' + this.post.image
                })
                .catch(error => { alert(error) })
        },
        updatepost() {
            let url = `/api/posts/${this.postId}`
            const formData = new FormData()
            if (this.fileInfo) {
                let date = new Date()
                this.post.image = date.getTime()  //ユニーク名 this.fileInfo.name
                formData.append('file', this.fileInfo)
            }
            formData.append('post', JSON.stringify(this.post))
            // alert(formData.get('post'))

            if (confirm("更新してよろしいですか？")) {
                axios.post(url, formData)
                    .then(Response => {
                        //リダイレクト
                        location.href = "/"
                    })
                    .catch(error => { alert(error) })
            }
        },
        uploadFile(event) {
            if (event.target.files[0] == void 0) {
                return
            }
            this.fileInfo = event.target.files[0];
            if (this.imageurl.length) {
                URL.revokeObjectURL(this.imageurl);
            }
            this.imageurl = URL.createObjectURL(this.fileInfo)
        }
    }
}

</script>