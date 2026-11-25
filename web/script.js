const baseUrl = 'http://localhost/IV1-23-1.loc/api';
const articlesUrl = `${baseUrl}/articles`;
const loginUrl = `${baseUrl}/user/login`;
const userCheckUrl = `${baseUrl}/user`;

const form = document.getElementById('articleForm');
const articles = document.querySelector('.articles');
const submitBtn = document.getElementById('submitBtn');
const cancelBtn = document.getElementById('cancelBtn');

const guestPanel = document.getElementById('guestPanel');
const userPanel = document.getElementById('userPanel');
const userNameSpan = document.getElementById('userName');
const showLoginBtn = document.getElementById('showLoginBtn');
const logoutBtn = document.getElementById('logoutBtn');
const loginForm = document.getElementById('loginForm');
const loginError = document.getElementById('loginError');

let authHeader = localStorage.getItem('authHeader') || null;
let currentUser = null;
let currentUserId = null;

function getAuthHeaders(extraHeaders = {}) {
    const headers = { ...extraHeaders };
    if (authHeader) {
        headers['Authorization'] = authHeader;
    }
    return headers;
}

showLoginBtn.addEventListener('click', () => {
    loginForm.style.display = loginForm.style.display === 'none' ? 'block' : 'none';
    loginError.textContent = '';
});

loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    loginError.textContent = '';

    const login = document.getElementById('loginEmail').value.trim();
    const password = document.getElementById('loginPassword').value;

    try {
        const res = await fetch(loginUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nickname: login, password })
        });

        const data = await res.json();

        if (res.ok && data.user && data.user !== 'No authenticated') {
            authHeader = 'Basic ' + btoa(unescape(encodeURIComponent(`${login}:${password}`)));
            localStorage.setItem('authHeader', authHeader);

            loginForm.reset();
            loginForm.style.display = 'none';
            await checkAuthAndRender();
        } else {
            loginError.textContent = data.error || 'Неверный логин или пароль';
        }
    } catch (err) {
        console.error('Ошибка при входе:', err);
        loginError.textContent = 'Ошибка соединения с сервером';
    }
});

logoutBtn.addEventListener('click', async () => {
    authHeader = null;
    currentUser = null;
    currentUserId = null;
    localStorage.removeItem('authHeader');

    try {
        await fetch(userCheckUrl, {
            headers: { 'Authorization': 'Basic ' + btoa('logout:logout') }
        });
    } catch (e) {}

    resetFormMode();
    renderUI(false);
});

async function checkAuthAndRender() {
    try {
        const res = await fetch(userCheckUrl, {
            headers: getAuthHeaders()
        });
        const data = await res.json();

        if (data.user && data.user !== 'No authenticated') {
            currentUser = data.user;
            currentUserId = Number(data.userId);
            renderUI(true);
        } else {
            authHeader = null;
            localStorage.removeItem('authHeader');
            currentUser = null;
            currentUserId = null;
            renderUI(false);
        }
    } catch (err) {
        console.error('Ошибка проверки авторизации:', err);
        renderUI(false);
    }
}

function renderUI(isAuthorized) {
    if (isAuthorized) {
        guestPanel.style.display = 'none';
        userPanel.style.display = 'block';
        userNameSpan.textContent = currentUser;
    } else {
        guestPanel.style.display = 'block';
        userPanel.style.display = 'none';
    }

    loadArticles();
}

function addArticleToPage(item) {
    let imgSrc = item.img || '';
    if (imgSrc && !imgSrc.startsWith('data:')) {
        imgSrc = '../' + imgSrc;
    }

    const articleAuthorId = Number(item.authorId ?? item.author_id);
    const canManage = currentUserId && articleAuthorId === currentUserId;

    const buttonsHtml = canManage ? `
        <button type="button" onclick="editArticleMode(${item.id})">Редактировать</button>
        <button type="button" onclick="deleteArticle(${item.id})">Удалить</button>
    ` : '';

    const html = `
        <li class="articles-list" id="article-${item.id}">
            <h1 class="art-name">${item.name}</h1>
            <img src="${imgSrc}" class="articles-img" style="${item.img ? '' : 'display:none;'}">
            <p class="art-text">${item.text || ''}</p>
            ${buttonsHtml}
        </li>
    `;
    articles.insertAdjacentHTML('beforeend', html);
}

function loadArticles() {
    articles.innerHTML = '';
    fetch(articlesUrl)
        .then(res => res.json())
        .then(data => {
            if (data.articles) {
                data.articles.forEach(addArticleToPage);
            }
        })
        .catch(err => console.error('Ошибка загрузки данных:', err));
}

window.editArticleMode = function(id) {
    const item = document.getElementById(`article-${id}`);
    document.getElementById('inputName').value = item.querySelector('.art-name').textContent;
    document.getElementById('inputText').value = item.querySelector('.art-text').textContent;

    form.dataset.editId = id;
    submitBtn.value = "Сохранить изменения";
    cancelBtn.style.display = "inline-block";
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

window.resetFormMode = function() {
    form.reset();
    delete form.dataset.editId;
    submitBtn.value = "Создать статью";
    cancelBtn.style.display = "none";
};

window.deleteArticle = async function(id) {
    if (!confirm('Удалить статью?')) return;
    try {
        const res = await fetch(`${articlesUrl}/${id}`, {
            method: 'DELETE',
            headers: getAuthHeaders()
        });
        const result = await res.json();
        if (res.ok && result.success) {
            document.getElementById(`article-${id}`).remove();
            alert('Статья успешно удалена!');
        } else {
            alert(result.error || 'Ошибка удаления на сервере');
        }
    } catch (err) {
        console.error('Ошибка при удалении:', err);
    }
};

const fileToBase64 = file => new Promise(res => {
    if (!file) return res(null);
    const r = new FileReader();
    r.readAsDataURL(file);
    r.onload = () => res(r.result);
    r.onerror = () => res(null);
});

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const editId = form.dataset.editId;

    try {
        const fileInput = document.getElementById('inputImg').files[0];
        const base64Image = await fileToBase64(fileInput);

        const payload = {
            article: {
                name: document.getElementById('inputName').value,
                text: document.getElementById('inputText').value
            }
        };

        if (base64Image) {
            payload.article.img = base64Image;
        }

        const fetchUrl = editId ? `${articlesUrl}/${editId}` : articlesUrl;
        const fetchMethod = editId ? 'PUT' : 'POST';

        const res = await fetch(fetchUrl, {
            method: fetchMethod,
            headers: getAuthHeaders({ 'Content-Type': 'application/json' }),
            body: JSON.stringify(payload)
        });

        const data = await res.json();

        if (!res.ok) {
            alert(data.error || `Ошибка сервера (код ${res.status})`);
            return;
        }

        if (editId) {
            const element = document.getElementById(`article-${editId}`);
            element.querySelector('.art-name').textContent = data.article.name;
            element.querySelector('.art-text').textContent = data.article.text;

            if (data.article && data.article.img) {
                const imgElement = element.querySelector('.articles-img');
                let savedImg = data.article.img;
                imgElement.src = savedImg.startsWith('data:') ? savedImg : '../' + savedImg;
                imgElement.style.display = 'block';
            }
            alert('Статья успешно обновлена!');
        } else if (data.article) {
            alert('Статья успешно создана!');
            
            if (!currentUser) {
                await checkAuthAndRender();
            } else {
                addArticleToPage(data.article);
            }
        }

        resetFormMode();
    } catch (err) {
        console.error('Критическая ошибка в JS коде:', err);
        alert('Не удалось отправить запрос к API.');
    }
});

checkAuthAndRender();
