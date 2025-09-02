@php
$colorStart = $color ?? '#5BC0F8'; // biru muda awal
$colorEnd = '#1DA1F2'; // biru muda lebih gelap untuk gradient
$height = $height ?? 60;
@endphp

<span style="display:inline-block;">
  <svg width="50" height="{{ $height }}" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
    <defs>
      <linearGradient id="gradN" x1="0%" y1="0%" x2="100%" y2="100%">
        <stop offset="0%" stop-color="{{ $colorStart }}" />
        <stop offset="100%" stop-color="{{ $colorEnd }}" />
      </linearGradient>
      <filter id="shadow" x="-20%" y="-20%" width="140%" height="140%">
        <feDropShadow dx="0" dy="5" stdDeviation="5" flood-color="#000" flood-opacity="0.2"/>
      </filter>
    </defs>
    <!-- Huruf N tebal dengan sudut sedikit rounded -->
    <path d="M15 85 L15 15 Q17 10 20 15 L75 85 Q78 90 80 85 L80 15" 
          stroke="url(#gradN)" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" fill="none" filter="url(#shadow)"/>
  </svg>
</span>
