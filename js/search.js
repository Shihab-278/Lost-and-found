// Live search with debounce and suggestion dropdown
(() => {
  const debounce = (fn, delay=300) => {
    let t;
    return (...args) => { clearTimeout(t); t = setTimeout(()=>fn(...args), delay); };
  };

  function createSuggestionItem(item){
    const li = document.createElement('li');
    li.className = 'list-group-item list-group-item-action';
    li.textContent = item.title;
    li.dataset.id = item.id;
    return li;
  }

  async function fetchSuggestions(q){
    if(!q) return [];
    try{
      const resp = await fetch(`search_suggest.php?q=${encodeURIComponent(q)}`);
      if(!resp.ok) return [];
      const data = await resp.json();
      return data;
    }catch(err){
      return [];
    }
  }

  function attachLiveSearch(inputId, sugId, clearBtnId){
    const input = document.getElementById(inputId);
    const sug = document.getElementById(sugId);
    const clearBtn = document.getElementById(clearBtnId);
    if(!input || !sug) return;

    const showSuggestions = (items) => {
      sug.innerHTML = '';
      if(!items || items.length === 0){ sug.style.display = 'none'; return; }
      items.forEach(it => sug.appendChild(createSuggestionItem(it)));
      sug.style.display = 'block';
    };

    const handleInput = debounce(async (e) => {
      const v = input.value.trim();
      if(v.length){
        clearBtn && clearBtn.classList.remove('d-none');
        const res = await fetchSuggestions(v);
        showSuggestions(res);
      } else {
        clearBtn && clearBtn.classList.add('d-none');
        showSuggestions([]);
      }
    }, 250);

    input.addEventListener('input', handleInput);

    // click suggestion
    sug.addEventListener('click', (ev) => {
      let el = ev.target;
      while(el && el !== sug){
        if(el.dataset && el.dataset.id){
          // go to single
          window.location.href = `single.php?id=${el.dataset.id}`;
          return;
        }
        el = el.parentElement;
      }
    });

    // keyboard navigation
    input.addEventListener('keydown', (ev) => {
      const items = [...sug.querySelectorAll('li')];
      if(!items.length) return;
      const active = sug.querySelector('.active');
      if(ev.key === 'ArrowDown'){
        ev.preventDefault();
        if(!active) items[0].classList.add('active');
        else{ active.classList.remove('active'); const idx = items.indexOf(active); items[(idx+1)%items.length].classList.add('active'); }
      } else if(ev.key === 'ArrowUp'){
        ev.preventDefault();
        if(!active) items[items.length-1].classList.add('active');
        else{ active.classList.remove('active'); const idx = items.indexOf(active); items[(idx-1+items.length)%items.length].classList.add('active'); }
      } else if(ev.key === 'Enter'){
        const sel = sug.querySelector('.active');
        if(sel){ ev.preventDefault(); window.location.href = `single.php?id=${sel.dataset.id}`; }
      }
    });

    // clear button
    if(clearBtn){
      clearBtn.addEventListener('click', () => { input.value=''; clearBtn.classList.add('d-none'); sug.innerHTML=''; sug.style.display='none'; input.focus(); });
    }

    // click outside to close
    document.addEventListener('click', (ev) => {
      if(!sug.contains(ev.target) && ev.target !== input && ev.target !== clearBtn){ sug.style.display='none'; }
    });
  }

  // helper used by forms to ensure suggestions don't intercept submit
  window.submitSearchFromInput = function(e, form){
    // allow normal submit
    return true;
  };

  // init on DOM ready
  document.addEventListener('DOMContentLoaded', () => {
    attachLiveSearch('header-search','header-search-suggestions','header-clear');
    attachLiveSearch('hero-search','hero-search-suggestions','hero-clear');
    attachLiveSearch('sidebar-search','sidebar-search-suggestions','sidebar-clear');
  });
})();
