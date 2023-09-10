// ログイン前に新規登録ボタンを押したときログインまたはアカウント作成のモーダル表示
document.addEventListener("DOMContentLoaded", function () {
    const openModalButton = document.getElementById("showModal");
    const closeModalButton = document.getElementById("closeModal");
    const modalContainer = document.getElementById("myModal");

    openModalButton.addEventListener("click", function () {
        modalContainer.style.display = "block";
    });

    closeModalButton.addEventListener("click", function () {
        modalContainer.style.display = "none";
    });

    window.addEventListener("click", function (event) {
        if (event.target === modalContainer) {
            modalContainer.style.display = "none";
        }
    });
});

// アカウント作成の登録ボタン
function showConfirmation() {
    const userName = document.getElementById('user_name').value;
    const password = document.getElementById('password').value;

    if (userName.trim() === '' || password.trim() === '') {
        const errorMessage = document.getElementById('error-message');
        errorMessage.style.display = 'block';
        return;
    }

    document.getElementById('confirmed-user_name').textContent = userName;
    document.getElementById('confirmed-password').textContent = password;

    const modal = document.getElementById('confirmation-modal');
    modal.style.display = 'block';
}

function closeConfirmation() {
    const modal = document.getElementById('confirmation-modal');
    modal.style.display = 'none';

    const errorMessage = document.getElementById('error-message');
    errorMessage.style.display = 'none';
}

function registerAccount() {
    const userName = document.getElementById('user_name').value;
    const password = document.getElementById('password').value;

    if (userName.trim() === '' || password.trim() === '') {
        const errorMessage = document.getElementById('error-message');
        errorMessage.style.display = 'block';
        return;
    }

    // フォームデータをオブジェクトとして作成
    const formData = new FormData();
    formData.append('user_name', userName);
    formData.append('password', password);

    // POSTリクエストを送信
    fetch('/blog/registration', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        // リダイレクトなどの処理
        // 例: メッセージを表示してリダイレクト
        alert(data.message);
        window.location.href = '/'; // リダイレクト先のURL
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// 送信確認(新規投稿と返信画面)
function checkSubmit(){
    if(window.confirm('送信してよろしいですか？')){
        return true;
    } else {
        return false;
    }
}

// 更新確認
function editCheckSubmit(){
    if(window.confirm('更新してよろしいですか？')){
        return true;
    } else {
        return false;
    }
}

// 削除確認
function checkDelete(){
    if(window.confirm('削除してよろしいですか？')){
        return true;
    } else {
        return false;
    }
}

// 対象記事のリンクコピーの処理
function copyToClipboard(text) {
    const tempInput = document.createElement("input");
    tempInput.value = text;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.body.removeChild(tempInput);
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("copyButton").addEventListener("click", function() {
        const currentUrl = window.location.href;
        copyToClipboard(currentUrl);
        alert("リンクがコピーされました: " + currentUrl);
    });
});

// 新規登録画面のhref属性のリンク制御かつフォーム送信
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('createLink').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('createForm').submit();
    });
});
