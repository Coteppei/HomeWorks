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

// ログアウト時確認モーダルを表示
document.addEventListener("DOMContentLoaded", function () {
    const openModalButton = document.getElementById("logoutModal");
    const closeModalButton = document.getElementById("logout_closeModal");
    const modalContainer = document.getElementById("submitModal");

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

// サインインの際に登録内容の確認モーダルを表示
document.addEventListener("DOMContentLoaded", function () {
    const openModalButton = document.getElementById("account_make_modal");
    const closeModalButton = document.getElementById("sign_up_closeModal");
    const modalContainer = document.getElementById("sign_up_Modal");

    openModalButton.addEventListener("click", function () {
        const userInput = document.getElementById('user_name').value;
        const passInput = document.getElementById('password').value;
        // ユーザー名およびパスワードが入力されている場合は、確認モーダルを表示
        if (userInput.trim() !== '' && passInput.trim() !== '') {
            const outputName = document.getElementById("output_user_name");
            const outputPass = document.getElementById("output_password");
            outputName.innerHTML = userInput;
            outputPass.innerHTML = passInput;
            modalContainer.style.display = "block";
        } else {
            // いずれかの入力が空の場合は入力喚起を表示
            alert("ユーザー名とパスワードを入力してください");
            return;
        }
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

// 送信確認(新規宿題投稿と返信画面)
function checkSubmit(){
    if(window.confirm('投稿してよろしいですか？')){
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

// 宿題解決の確認
function checkResolve(){
    if(window.confirm('宿題が解決しましたか？')){
        return true;
    } else {
        return false;
    }
}

// 対象記事のリンクコピーの処理-廃止
// function copyToClipboard(text) {
//     const tempInput = document.createElement("input");
//     tempInput.value = text;
//     document.body.appendChild(tempInput);
//     tempInput.select();
//     document.body.removeChild(tempInput);
// }

// document.addEventListener("DOMContentLoaded", function() {
//     document.getElementById("copyButton").addEventListener("click", function() {
//         const currentUrl = window.location.href;
//         copyToClipboard(currentUrl);
//         alert("リンクがコピーされました: " + currentUrl);
//     });
// });

// 新規登録画面のhref属性のリンク制御かつフォーム送信
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('createLink').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('createForm').submit();
    });
});
