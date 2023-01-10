
<template>
  <div class="wrapper" width="300" height="300">
    <canvas class="backbox" id="backbox" width="300" height="300">Back</canvas>
    <canvas class="box" width="100" height="100">One</canvas>
    <canvas class="box" width="100" height="100">Two</canvas>
    <canvas class="box" width="100" height="100">Three</canvas>
    <canvas class="box" width="100" height="100">Four</canvas>
    <canvas class="box" width="100" height="100">Five</canvas>
    <canvas class="box" width="100" height="100">Six</canvas>
    <canvas class="box" width="100" height="100">Seven</canvas>
    <canvas class="box" width="100" height="100">Eight</canvas>
    <canvas class="box" width="100" height="100">Nine</canvas>
  </div>
</template>

<script>
const PLAYER_TYPE = { none: 0, maru: 1, batsu: 2 };
const BOX_WIDTH = 100;
const BOX_POSITION = {
  topLeft: 0, topMiddle: 1, topRight: 2,
  middleLeft: 3, middleMiddle: 4, middleRight: 5,
  bottomLeft: 6, bottomMiddle: 7, bottomRight: 8,
};
export default {
  data() {
    return {
      curplayer: String,
      stateList: Array,
      onClickBind: Function
    }
  },

  mounted() {
    this.stateList = new Array;
    this.curplayer = String(PLAYER_TYPE.maru);
    this.onClickBind = this.clicked.bind(this);
    const boxs = document.getElementsByClassName('box');
    for (let i = 0; i < boxs.length; i++) {
      this.stateList.push(PLAYER_TYPE.none);
      boxs[i].id = i;
      boxs[i].addEventListener('click', this.onClickBind);
    }
    this.drawback();
  },
  methods: {
    clicked: function (event) {
      let index = event.currentTarget.id;
      if (this.stateList[index] == PLAYER_TYPE.none) {
        this.stateList[index] = this.curplayer;
        if (this.curplayer == PLAYER_TYPE.maru) {
          this.drawMaru(event.currentTarget.getContext('2d'))
        } else {
          this.drawBatsu(event.currentTarget.getContext('2d'))
        }
        this.curplayer = (this.curplayer == PLAYER_TYPE.maru) ? PLAYER_TYPE.batsu : PLAYER_TYPE.maru;
        if (this.checkDecision() != PLAYER_TYPE.none) {
          this.finishGame()
        }
      }
    },
    drawback: function () {
      const ctx = document.getElementById('backbox').getContext('2d');
      ctx.save();
      ctx.clearRect(0, 0, BOX_WIDTH * 3, BOX_WIDTH * 3);
      ctx.strokeStyle = '#808080';
      ctx.fillStyle = 'white';
      ctx.lineWidth = 8;

      ctx.moveTo(BOX_WIDTH, 0);
      ctx.lineTo(BOX_WIDTH, BOX_WIDTH * 3);
      ctx.stroke();

      ctx.moveTo(BOX_WIDTH * 2, 0);
      ctx.lineTo(BOX_WIDTH * 2, BOX_WIDTH * 3);
      ctx.stroke();

      ctx.moveTo(0, BOX_WIDTH);
      ctx.lineTo(BOX_WIDTH * 3, BOX_WIDTH);
      ctx.stroke();

      ctx.moveTo(0, BOX_WIDTH * 2);
      ctx.lineTo(BOX_WIDTH * 3, BOX_WIDTH * 2);
      ctx.stroke();

      ctx.restore();
    },
    drawMaru: function (ctx) {
      ctx.save();
      ctx.beginPath();
      ctx.strokeStyle = 'blue';
      ctx.fillStyle = 'white';
      ctx.lineWidth = 10;
      ctx.arc(BOX_WIDTH / 2, BOX_WIDTH / 2, BOX_WIDTH * 0.7 / 2, 0, Math.PI * 2, true);
      ctx.stroke();

      ctx.restore();
    },
    drawBatsu: function (ctx) {
      ctx.save();
      ctx.beginPath();
      ctx.strokeStyle = 'red';
      ctx.lineWidth = 10;
      ctx.lineCap = 'round';

      ctx.moveTo(BOX_WIDTH * 0.2, BOX_WIDTH * 0.2);
      ctx.lineTo(BOX_WIDTH * 0.8, BOX_WIDTH * 0.8);
      ctx.stroke();

      ctx.moveTo(BOX_WIDTH * 0.8, BOX_WIDTH * 0.2);
      ctx.lineTo(BOX_WIDTH * 0.2, BOX_WIDTH * 0.8);
      ctx.stroke();

      ctx.restore();
    },
    drawResult: function (from, to) {
      const ctx = document.getElementById('backbox').getContext('2d');
      ctx.save();
      ctx.beginPath();
      ctx.strokeStyle = 'black';
      ctx.fillStyle = 'white';
      ctx.lineWidth = 12;

      let startX , startY , endX , endY;
      startX = startY = endX = endY = 0;
      
      switch (from) {
        case BOX_POSITION.topLeft:
          switch (to) {
            case BOX_POSITION.topRight: //横
              startY = BOX_WIDTH / 2;
              endX = BOX_WIDTH * 3;
              endY = startY;
              break;
            case BOX_POSITION.bottomLeft: //縦
              startX = BOX_WIDTH / 2;
              endY = BOX_WIDTH * 3;
              endX = startX;
              break;
            case BOX_POSITION.bottomRight:
              endX = BOX_WIDTH * 3;
              endY = BOX_WIDTH * 3;
              break;
          }
          break;
        case BOX_POSITION.topMiddle:
          startX = BOX_WIDTH * 1.5;
          endY = BOX_WIDTH * 3;
          endX = startX;
          break;
        case BOX_POSITION.topRight:
          switch (to) {
            case BOX_POSITION.bottomRight: //縦
              startX = BOX_WIDTH * 2.5;
              endY = BOX_WIDTH * 3;
              endX = startX;
              break;
            case BOX_POSITION.bottomLeft:
              startX = BOX_WIDTH * 3;
              endY = BOX_WIDTH * 3;
              break;
          }
          break;
        case BOX_POSITION.middleLeft:
          startY = BOX_WIDTH * 1.5;
          endX = BOX_WIDTH * 3;
          endY = startY;
          break;
        case BOX_POSITION.bottomLeft:
          startY = BOX_WIDTH * 2.5;
          endX = BOX_WIDTH * 3;
          endY = startY;
          break;
      }

      ctx.moveTo(startX, startY);
      ctx.lineTo(endX, endY);
      ctx.stroke();

      ctx.restore();
    },
    finishGame: function () {
      const backbox = document.getElementById('backbox');
      backbox.style.zIndex = 2;
      const boxs = document.getElementsByClassName('box');
      for (let i = 0; i < boxs.length; i++) {
        boxs[i].removeEventListener('click', this.onClickBind);
      }
    },
    checkDecision: function () {
      let winner = PLAYER_TYPE.none;
      let i, j;
      //縦
      for (i = 0; i < 3; i++) {
        winner = this.stateList[i];
        if (winner == PLAYER_TYPE.none) continue;
        for (j = 1; j < 3; j++) {
          if (winner != this.stateList[j * 3 + i]) {
            winner = PLAYER_TYPE.none;
            break;
          }
        }
        if (winner != PLAYER_TYPE.none) break;
      }
      if (winner != PLAYER_TYPE.none) {
        //勝者決定
        console.log(`${winner}が勝ちました`);
        this.drawResult(i, i + 6);
        return winner;
      }

      //横
      for (i = 0; i < 3; i++) {
        winner = this.stateList[i * 3];
        if (winner == PLAYER_TYPE.none) continue;
        for (j = 1; j < 3; j++) {
          if (winner != this.stateList[i * 3 + j]) {
            winner = PLAYER_TYPE.none;
            break;
          }
        }
        if (winner != PLAYER_TYPE.none) break;
      }
      if (winner != PLAYER_TYPE.none) {
        //勝者決定
        console.log(`${winner}が勝ちました`);
        this.drawResult(i * 3, i * 3 + 2);
        return winner;
      }

      //斜め\
      winner = this.stateList[BOX_POSITION.topLeft];
      if (winner != PLAYER_TYPE.none) {
        if (winner == this.stateList[BOX_POSITION.middleMiddle]) {
          if (winner == this.stateList[BOX_POSITION.bottomRight]) {
            //勝者決定
            console.log(`${winner}が勝ちました`);
            this.drawResult(BOX_POSITION.topLeft, BOX_POSITION.bottomRight);
            return winner;
          }
        }
      }
      //斜め/
      winner = this.stateList[BOX_POSITION.topRight];
      if (winner != PLAYER_TYPE.none) {
        if (winner == this.stateList[BOX_POSITION.middleMiddle]) {
          if (winner == this.stateList[BOX_POSITION.bottomLeft]) {
            //勝者決定
            console.log(`${winner}が勝ちました`);
            this.drawResult(BOX_POSITION.topRight, BOX_POSITION.bottomLeft);
            return winner;
          }
        }
      }
      return PLAYER_TYPE.none;
    },

  }
}
</script>
</body>
<style>
.wrapper {
  display: grid;
  grid-template-columns: repeat(3, 100px);
  grid-auto-rows: 100px;
}

.backbox {
  z-index: 0;
  position: absolute;
}

.box {
  z-index: 1;
}
</style>
