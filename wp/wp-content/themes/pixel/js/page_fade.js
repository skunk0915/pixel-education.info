// �����ǣ��
(function() {
    'use strict';

    // ��ǣ�;bnHTML� �\
    const loadingOverlay = document.createElement('div');
    loadingOverlay.id = 'page-loading-overlay';
    loadingOverlay.innerHTML = `
        <div class="loading-spinner">
            <div class="spinner"></div>
        </div>
    `;

    // ������
    const style = document.createElement('style');
    style.textContent = `
        #page-loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #ffffff;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 1s ease-out;
        }

        #page-loading-overlay.fade-out {
            opacity: 0;
        }

        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #333333;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        body.loading {
            overflow: hidden;
        }
    `;

    // DOMk� ���
    document.head.appendChild(style);
    document.addEventListener('DOMContentLoaded', function() {
        document.body.appendChild(loadingOverlay);
        document.body.classList.add('loading');
    });

    // ����h���Bn�
    window.addEventListener('load', function() {
        // ��ǣ�;b�է�ɢ��
        loadingOverlay.classList.add('fade-out');
        document.body.classList.remove('loading');

        // ������󌆌k� �Jd
        setTimeout(function() {
            if (loadingOverlay.parentNode) {
                loadingOverlay.parentNode.removeChild(loadingOverlay);
            }
        }, 500); // 0.5ҌkJd
    });
})();
