$('document').ready(() => {
  /**
   * RIBON 連携
   */
  $(function() {
    $.ajax({
      url: 'ribon',
      dataType: 'json'
    }).done((e) => {
      // 成功 = データが取得できた場合のみ、処理を続行する
      // .ribon-link を対象に処理
      for (const link of document.getElementsByClassName('ribon-link')) {
        const classes = link.classList
        if (link.tagName === 'A') {
          // 要素がアンカータグの場合は href 等を指定する
          link.href = e.url
          link.title = e.title + 'の採用情報をribonで見る'
          link.target = "_blank"
          link.rel = "noopener"
        }
        // 表示
        if (!classes.contains('ribon-link--no-display')) {
          link.style.display = 'initial'
        }
        if (classes.contains('ribon-link--auto')) {
          link.insertAdjacentHTML('afterbegin', drawRibonButton(e))
        }
      }
      // .ribon-link-alt を非表示にする
      for (const alter of document.getElementsByClassName('ribon-link-alt')) {
        alter.style.display = 'none'
      }
    })
  })

  /**
   * デフォルトの画像バナーを使う場合に描画するボタン
   * @param { url: string; title: string } data
   * @return HTML
   */
  const drawRibonButton = (data) => {
      return [
      '<style>',
      '.ribon-banner {',
      'background: url("ribon/src/banner.png");',
      'background-repeat: no-repeat;',
      'background-size: contain;',
      'border-radius: 5px;',
      'color: #fff;',
      'display: inline-block;',
      'height: 108px;',
      'text-decoration: none;',
      'transition: 0.3s;',
      'width: 300px;',
      '}',
      '.ribon-banner:hover {',
      'opacity: 0.75;',
      'transition: 0.3s;',
      '}',
      '</style>',
      '<a href="',
      data.url,
      '" title="',
      data.title,
      'の採用情報をribonで見る',
      '" rel="noopener" class="ribon-banner" target="_blank"></a>'
    ].join('')
  }
});
