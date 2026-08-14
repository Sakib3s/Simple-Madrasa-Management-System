document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const button = document.getElementById('menu-button');
    const toggleMenu = () => {
        sidebar?.classList.toggle('-translate-x-full');
        overlay?.classList.toggle('hidden');
    };
    button?.addEventListener('click', toggleMenu);
    overlay?.addEventListener('click', toggleMenu);
    document.querySelectorAll('.flash-message').forEach((message) => {
        window.setTimeout(() => message.remove(), 4000);
    });
    document.querySelectorAll('[data-confirm]').forEach((element) => {
        element.addEventListener('click', (event) => {
            if (!window.confirm(element.dataset.confirm)) event.preventDefault();
        });
    });
    const amount = document.querySelector('[name="amount"]');
    const paid = document.querySelector('[name="paid_amount"]');
    const due = document.querySelector('[name="due_amount"]');
    const status = document.querySelector('[name="status"]');
    const updateFee = () => {
        if (!amount || !paid || !due || !status) return;
        const total = Math.max(0, Number(amount.value) || 0);
        const paidValue = Math.min(total, Math.max(0, Number(paid.value) || 0));
        due.value = (total - paidValue).toFixed(2);
        status.value = paidValue >= total && total > 0 ? 'Paid' : paidValue > 0 ? 'Partial' : 'Due';
    };
    amount?.addEventListener('input', updateFee);
    paid?.addEventListener('input', updateFee);
});
