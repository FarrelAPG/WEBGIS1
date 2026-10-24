{{-- Ikon marker pos pemadam (gedung pos + pintu garasi), dipakai di peta laporan & peta jangkauan.
     Pemakaian: L.marker([lat, lng], { icon: buatIkonPosDamkar('Nama Pos') })  — label opsional.
     Butuh Leaflet (L) sudah dimuat saat fungsi dipanggil. --}}
<script>
    function buatIkonPosDamkar(label = null) {
        const esc = (t) => String(t).replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));
        const labelHtml = label
            ? `<span style="position:absolute;top:48px;left:50%;transform:translateX(-50%);max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;background:rgba(255,255,255,.95);border:1px solid #f1f5f9;border-radius:6px;padding:1px 8px;font:700 10px/1.5 sans-serif;color:#334155;box-shadow:0 1px 2px rgba(0,0,0,.12)">${esc(label)}</span>`
            : '';

        return L.divIcon({
            className: 'pos-damkar-marker',
            html: `<div style="position:relative;width:36px;height:44px">
                <div style="width:36px;height:36px;border-radius:12px;background:#E52329;border:2px solid #fff;box-shadow:0 4px 10px rgba(0,0,0,.3);display:flex;align-items:center;justify-content:center;box-sizing:border-box">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="#fff" aria-hidden="true">
                        <path d="M12 2 2 8.2V10h20V8.2L12 2z"/>
                        <path fill-rule="evenodd" d="M4 11.5h16V21H4v-9.5zM8 21h8v-7.2a4 4 0 0 0-8 0V21z"/>
                        <path d="M9.4 16h5.2v1.1H9.4zM9.4 18.4h5.2v1.1H9.4z"/>
                    </svg>
                </div>
                <div style="position:absolute;left:50%;bottom:0;transform:translateX(-50%);width:0;height:0;border-left:7px solid transparent;border-right:7px solid transparent;border-top:9px solid #E52329"></div>
                ${labelHtml}
            </div>`,
            iconSize: [36, 44],
            iconAnchor: [18, 44],
            popupAnchor: [0, -44],
        });
    }
</script>
<style>.pos-damkar-marker { background: transparent; border: none; }</style>
