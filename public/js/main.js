//


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
