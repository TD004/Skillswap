// Lightweight interactivity: top swaps animation, live search polling for matches
document.addEventListener('DOMContentLoaded', ()=>{
    // rotate top swaps
    const swaps = document.querySelectorAll('#top-swaps li');
    let i=0;
    if(swaps.length>0) setInterval(()=>{
      swaps.forEach(s=>s.style.display='none');
      swaps[i].style.display='block';
      i=(i+1)%swaps.length;
    },3000);
  
    // optional: fetch matches for dashboard live
    if(document.getElementById('matches')){
      fetch('match.php').then(r=>r.json()).then(data=>{
        const el = document.getElementById('matches');
        if(!data || data.length===0) return;
        el.innerHTML = '';
        data.forEach(m=>{
          const row = document.createElement('div'); row.className='match-row';
          row.innerHTML = `<div><strong>${escapeHtml(m.name)}</strong><div class='muted'>${escapeHtml(m.location||'')}</div></div><div class='match-skills'>${escapeHtml(m.offered_skill)} → you</div><a class='btn-small' href='chat.php?with=${m.other_id}'>Chat</a>`;
          el.appendChild(row);
        })
      }).catch(e=>{
        // silent fail - helpful during dev
        console.log('match fetch error', e);
      })
    }
  
    // small helper to avoid injecting raw HTML
    function escapeHtml(unsafe) {
      return String(unsafe).replace(/[&<>"'`=\/]/g, function(s) {
        return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','/':'&#x2F;','`':'&#x60;','=':'&#x3D;'}[s];
      });
    }
  });
  
