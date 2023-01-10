<template>
    <div>
        <post-message title="新規投稿フォーム" content="コメントと画像を登録"> </post-message>
        <form @submit.prevent="savepost" class="my-5">

            <div class="form-group mb-3">
                <label for="inputContent" class="form-label lead">内容</label>
                <textarea class="form-control" id="inputContent" rows="6" v-model="post.content" required></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="inputImage" class="form-label lead">画像</label>
                <div v-if="imageurl">
                    <img :src="imageurl" width="100%">
                </div>
                <input class="form-control" id="inputImage" @change="uploadFile" type="file" accept="image/*" required>
            </div>

            <div class="mt-5">
                <a class="btn btn-secondary" href="/">
                    キャンセル
                </a>
                <button type="submit" class="btn btn-primary">
                    投稿する
                </button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            post: {},
            fileInfo: '',
            imageurl: "",
        };
    },
    created() {
        this.post.image = ""
    },
    computed: {

    },
    methods: {
        savepost() {
            let date = new Date()
            this.post.image = date.getTime()  //ユニーク名 this.fileInfo.name

            const formData = new FormData()
            formData.append('file', this.fileInfo)
            formData.append('post', JSON.stringify(this.post))

            let url = `/api/posts`
            if (confirm("投稿してよろしいですか？")) {
                axios.post(url, formData)
                    .then(Response => {
                        //リダイレクト
                        location.href = "/"
                    })
                    .catch(error => { alert(error) })
            }
        },
        uploadFile(event) {
            if (this.imageurl.length) {
                URL.revokeObjectURL(this.imageurl);
            }
            this.fileInfo = event.target.files[0];
            if (this.fileInfo != void 0) {
                this.imageurl = URL.createObjectURL(this.fileInfo)
            } else {
                this.imageurl = ""
            }
        }
    }
}

</script>