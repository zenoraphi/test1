<style>
.form-input{
    width:100%;
    border-radius:1rem;
    padding:0.75rem 1rem;
    border:1px solid #e5e7eb;
    transition:all .3s ease;
}
.form-input:focus{
    outline:none;
    
    transform:translateY(-2px);
    box-shadow:0 10px 25px rgba(59,130,246,.15);
    border-color:#3b82f6;
}

.animate-slide-down{animation:slideDown .6s ease-out}
.animate-scale-fade{animation:scaleFade .6s ease-out}
.animate-stagger{
    animation:fadeUp .6s ease forwards;
    opacity:0;
}

.animate-stagger:nth-child(1){animation-delay:.05s}
.animate-stagger:nth-child(2){animation-delay:.1s}
.animate-stagger:nth-child(3){animation-delay:.15s}
.animate-stagger:nth-child(4){animation-delay:.2s}
.animate-stagger:nth-child(5){animation-delay:.25s}
.animate-stagger:nth-child(6){animation-delay:.3s}
.animate-stagger:nth-child(7){animation-delay:.35s}

@keyframes slideDown{
    from{opacity:0;transform:translateY(-20px)}
    to{opacity:1;transform:translateY(0)}
}
@keyframes scaleFade{
    from{opacity:0;transform:scale(.95)}
    to{opacity:1;transform:scale(1)}
}
@keyframes fadeUp{
    from{opacity:0;transform:translateY(10px)}
    to{opacity:1;transform:translateY(0)}
}
</style>
