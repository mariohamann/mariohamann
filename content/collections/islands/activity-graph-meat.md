---
id: 41ac3286-67d5-43ed-a054-5f9e7811fb54
blueprint: island
title: activity-graph-meat
head:
  code: null
  mode: handlebars
body:
  code: |-
    <activity-graph
    	class="not-prose"
        range-start="2024-01-01"
        range-end="2024-12-31"
        activity-data="2024-01-14,2024-03-15,2024-09-04,2024-09-12"
        activity-levels="0,1"
    	first-day-of-week="1"
    	i18n='{"less":"🌱 No Meat","more":"🍖 Meat"}'
    ></activity-graph>
  mode: handlebars
placeholder:
  code: |-
    <div slot="loading" hidden>
    <div class="skeleton" style="width:90%;"></div>
              <div class="skeleton" style="width:55%;"></div>
              <div class="skeleton" style="width:80%;"></div>
              <div class="skeleton" style="width:65%;"></div>
              <div class="skeleton" style="width:85%;"></div>
    		  </div>
  mode: handlebars
lazy_loading: false
updated_by: 225d58b0-3de7-45fb-b9a6-a2f543c6834c
updated_at: 1728764262
---
