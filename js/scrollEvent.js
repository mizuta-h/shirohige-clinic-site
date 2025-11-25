//----------------------------------------------------------------//
//IntersectionObserver APIを使用したスクロール監視処理
//
//【使い方】
// 動かしたい要素に「.anim」を付与すると、
// 画面に要素が入ったタイミングで「.is-visible」というクラスが追加されます。
// 時間差で動かしたい場合（左右から順繰りにフェードインなど）は、
//「data-timer」というdata属性を使用してください。
// data-timerに入れた数値分だけ遅延して実行されます。
//
//【htmlでの書き方】
// ・0.5秒後にis-visibleをつけたい場合
// <div class="anim" data-timer="500">
//----------------------------------------------------------------//

// 交差を監視する要素
const animItem = document.querySelectorAll(".anim");
const animArray = Array.prototype.slice.call(animItem, 0);
const options = {
  root: null, // ビューポートをルート要素とする
  rootMargin: "0px 0px -20% 0px", // スクロールで21%目に要素が入ればイベントが発生
  threshold: 0 // 閾値は0
};

const observer = new IntersectionObserver(doWhenIntersect, options);
// それぞれアニメーションさせたい要素を監視する
animArray.forEach(function(anim) {
  observer.observe(anim);
});

/**
 * 交差したときに呼び出す関数
 * @param entries
 */
function doWhenIntersect(entries) {
  const entriesArray = Array.prototype.slice.call(entries, 0);
  entriesArray.forEach(function (entry) {
    if (entry.isIntersecting) {
      const timer = Number(entry.target.dataset.timer) // data-timer の値を取得し、数値化する
      const delay = timer;
      setTimeout(function(){
        entry.target.classList.add("is-visible");
      },delay);
    }
  });
}

