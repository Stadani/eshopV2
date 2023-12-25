<link rel="stylesheet" href="/css/forumStyle.css">
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'button_bar transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
