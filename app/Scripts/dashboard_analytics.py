import os, sys, json, io, base64
import pandas as pd

# Fix path untuk Windows/Laragon
temp_config = os.path.join(os.path.dirname(__file__), 'matplotlib_tmp')
if not os.path.exists(temp_config):
    os.makedirs(temp_config)
os.environ['MPLCONFIGDIR'] = temp_config

import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot as plt

def generate_charts():
    try:
        if len(sys.argv) < 2:
            return json.dumps({'flow': '', 'category': ''})
        
        df = pd.DataFrame(json.loads(sys.argv[1]))
        if df.empty or 'trans_date' not in df.columns:
            return json.dumps({'flow': '', 'category': ''})
        
        df['trans_date'] = pd.to_datetime(df['trans_date'])

        # --- KONFIGURASI GLOBAL FONT ---
        plt.rcParams.update({'font.size': 12}) # Memperbesar font dasar

        # --- CHART 1: LINE CHART (Cashflow) ---
        fig1, ax1 = plt.subplots(figsize=(12, 6)) # Ukuran lebih besar
        daily = df.groupby(['trans_date', 'type'])['amount'].sum().unstack(fill_value=0).sort_index()
        
        if 'income' in daily:
            ax1.plot(daily.index, daily['income'], color='#10b981', linewidth=4, 
                     marker='o', markersize=8, label='Pemasukan', mfc='white', mew=2)
        if 'expense' in daily:
            ax1.plot(daily.index, daily['expense'], color='#f43f5e', linewidth=4, 
                     marker='o', markersize=8, label='Pengeluaran', mfc='white', mew=2)
        
        # Styling Label
        ax1.set_title('Tren Arus Kas', fontsize=16, fontweight='bold', pad=20, color='#1e293b')
        ax1.legend(fontsize=11, frameon=False, loc='upper left')
        ax1.tick_params(axis='both', which='major', labelsize=10, colors='#64748b')
        
        # Grid transparan
        ax1.grid(True, axis='y', linestyle='--', alpha=0.5)
        ax1.spines['top'].set_visible(False)
        ax1.spines['right'].set_visible(False)
        ax1.spines['left'].set_color('#e2e8f0')
        ax1.spines['bottom'].set_color('#e2e8f0')
        
        buf1 = io.BytesIO()
        fig1.savefig(buf1, format='png', transparent=True, bbox_inches='tight', dpi=100)
        flow_base64 = base64.b64encode(buf1.getvalue()).decode()
        plt.close(fig1)

        # --- CHART 2: DONUT CHART (Expense Distribution) ---
        expenses = df[df['type'] == 'expense']
        if not expenses.empty:
            cat_data = expenses.groupby('category')['amount'].sum()
            fig2, ax2 = plt.subplots(figsize=(8, 8))
            colors = ['#1e293b', '#6366f1', '#8b5cf6', '#ec4899', '#f59e0b']
            
            # Pie chart dengan label yang lebih besar dan persentase
            wedges, texts, autotexts = ax2.pie(
                cat_data, 
                labels=cat_data.index, 
                colors=colors,
                autopct='%1.1f%%',
                startangle=140,
                pctdistance=0.85,
                wedgeprops={'width': 0.45, 'edgecolor': 'white', 'linewidth': 3},
                textprops={'fontsize': 12, 'color': '#1e293b', 'fontweight': 'bold'}
            )
            
            # Styling persentase di dalam donut
            for autotext in autotexts:
                autotext.set_color('white')
                autotext.set_fontsize(10)

            ax2.set_title('Distribusi Biaya', fontsize=16, fontweight='bold', pad=10, color='#1e293b')
            
            buf2 = io.BytesIO()
            fig2.savefig(buf2, format='png', transparent=True, bbox_inches='tight', dpi=100)
            cat_base64 = base64.b64encode(buf2.getvalue()).decode()
            plt.close(fig2)
        else:
            cat_base64 = ''

        return json.dumps({'flow': flow_base64, 'category': cat_base64})

    except Exception as e:
        return json.dumps({'error': str(e), 'flow': '', 'category': ''})

if __name__ == "__main__":
    sys.stdout.write(generate_charts())