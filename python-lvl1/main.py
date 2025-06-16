import tkinter as tk
from tkinter import ttk, messagebox
import sqlite3

conn = sqlite3.connect("corralon.db")
cursor = conn.cursor()
cursor.execute("""
    CREATE TABLE IF NOT EXISTS articulos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nombre TEXT NOT NULL,
        precio REAL NOT NULL
    )
""")
conn.commit()

def cargar_datos():
    for item in tree.get_children():
        tree.delete(item)
    cursor.execute("SELECT * FROM articulos")
    for row in cursor.fetchall():
        tree.insert("", "end", values=row)

def seleccionar_item(event):
    seleccionado = tree.focus()
    if not seleccionado:
        return
    valores = tree.item(seleccionado, 'values')
    entry_id.config(state='normal')
    entry_id.delete(0, tk.END)
    entry_nombre.delete(0, tk.END)
    entry_precio.delete(0, tk.END)
    entry_id.insert(0, valores[0])
    entry_id.config(state='readonly')
    entry_nombre.insert(0, valores[1])
    entry_precio.insert(0, valores[2])

def guardar_cambios(event=None):
    try:
        id_item = int(entry_id.get())
        nombre = entry_nombre.get().strip()
        precio = float(entry_precio.get())

        if not nombre:
            messagebox.showwarning("Faltan datos", "El nombre no puede estar vacío.")
            return
        cursor.execute("""
            SELECT COUNT(*) FROM articulos
            WHERE LOWER(nombre) = LOWER(?) AND id != ?
        """, (nombre, id_item))
        if cursor.fetchone()[0] > 0:
            messagebox.showerror("Error", f"Ya existe un artículo llamado '{nombre}'.")
            return

        cursor.execute("UPDATE articulos SET nombre = ?, precio = ? WHERE id = ?", (nombre, precio, id_item))
        conn.commit()
        cargar_datos()
    except ValueError:
        messagebox.showerror("Error", "Verificá los datos (precio debe ser número).")

def agregar_articulo():
    nombre = entry_nombre.get().strip()
    precio = entry_precio.get()

    if not nombre or not precio:
        messagebox.showwarning("Faltan datos", "Completá nombre y precio.")
        return

    cursor.execute("SELECT COUNT(*) FROM articulos WHERE LOWER(nombre) = LOWER(?)", (nombre,))
    if cursor.fetchone()[0] > 0:
        messagebox.showerror("Error", f"El artículo '{nombre}' ya existe.")
        return

    try:
        cursor.execute("INSERT INTO articulos (nombre, precio) VALUES (?, ?)", (nombre, float(precio)))
        conn.commit()
        cargar_datos()
        entry_nombre.delete(0, tk.END)
        entry_precio.delete(0, tk.END)
    except ValueError:
        messagebox.showerror("Error", "Precio debe ser numérico.")

def eliminar_articulo():
    try:
        id_item = int(entry_id.get())
        cursor.execute("DELETE FROM articulos WHERE id = ?", (id_item,))
        conn.commit()
        cargar_datos()
        entry_id.config(state='normal')
        entry_id.delete(0, tk.END)
        entry_id.config(state='readonly')
        entry_nombre.delete(0, tk.END)
        entry_precio.delete(0, tk.END)
    except ValueError:
        messagebox.showerror("Error", "Seleccioná un artículo válido.")

ventana = tk.Tk()
ventana.title("ABM Corralón")
ventana.geometry("550x550")

frame_form = tk.Frame(ventana)
frame_form.pack(pady=10)

tk.Label(frame_form, text="ID").grid(row=0, column=0, padx=5)
entry_id = tk.Entry(frame_form, state="readonly", width=10)
entry_id.grid(row=0, column=1, padx=5)

tk.Label(frame_form, text="Nombre").grid(row=1, column=0, padx=5)
entry_nombre = tk.Entry(frame_form, width=30)
entry_nombre.grid(row=1, column=1, padx=5)

tk.Label(frame_form, text="Precio").grid(row=2, column=0, padx=5)
entry_precio = tk.Entry(frame_form, width=30)
entry_precio.grid(row=2, column=1, padx=5)

frame_btns = tk.Frame(ventana)
frame_btns.pack(pady=5)

tk.Button(frame_btns, text="Agregar", command=agregar_articulo).grid(row=0, column=0, padx=10)
tk.Button(frame_btns, text="Eliminar", command=eliminar_articulo).grid(row=0, column=1, padx=10)

columns = ("ID", "Nombre", "Precio")
tree = ttk.Treeview(ventana, columns=columns, show="headings", height=15)
for col in columns:
    tree.heading(col, text=col)
    tree.column(col, anchor='center', width=150)

tree.pack(pady=10, expand=True, fill='both')

tree.bind("<<TreeviewSelect>>", seleccionar_item)
entry_nombre.bind("<Return>", guardar_cambios)
entry_precio.bind("<Return>", guardar_cambios)

cargar_datos()
ventana.mainloop()